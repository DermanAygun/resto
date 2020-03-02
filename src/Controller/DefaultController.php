<?php

namespace App\Controller;

use App\Entity\Barman;
use App\Entity\Bestelling;
use App\Entity\MenuItem;
use App\Entity\Tafel;
use App\Entity\Reservatie;
use App\Form\BestellingType;
use App\Form\BestelType;
use App\Form\ReserveringType;

use \DateTime;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class DefaultController extends AbstractController
{
    /**
 * @Route("/", name="default")
 */
    public function index()
    {
        $repo = $this->getDoctrine();

        $tafels = $repo->getRepository(Tafel::class)->findAll();

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'tafels' => $tafels,
        ]);
    }

    /**
     * @Route("/menukaart", name="menukaart")
     */
    public function menukaart()
    {
        $repo = $this->getDoctrine();

        $menus = $repo->getRepository(MenuItem::class)->findAll();
        $dranken = $repo->getRepository(Barman::class)->findAll();

        return $this->render('default/menukaart.html.twig', [
            'controller_name' => 'DefaultController',
            'menus' => $menus,
            'dranken' => $dranken,
        ]);
    }

    /**
     * @Route("/reserveer", name="reserveer", methods={"GET","POST"})
     */
    public function reserveer(Request $request): Response
    {
        $reservatie = new Reservatie();

        $repo = $this->getDoctrine();
        $tafels = $repo->getRepository(Tafel::class)->findAll();

        $form = $this->createForm(ReserveringType::class, $reservatie);
        $form->handleRequest($request);
        $formData = $form->getData();

        $datetime = new DateTime();

        if ($form->isSubmitted() && $form->isValid()) {

            if ($reservatie->getTafel()->getGereserveerd() == 1) {
                echo "De gekozen tafel is gereserveerd";
            } else if ($reservatie->getTafel()->getGereserveerd() == 0) {
                $reservatie->setDatum($datetime);
                $reservatie->setTijd($datetime);

                $reservatie->getTafel()->setGereserveerd(1);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($reservatie);
                $entityManager->flush();

                return $this->redirectToRoute('reserveringen');
            }
        }

        return $this->render('default/reserveer.html.twig', [
            'reservatie' => $reservatie,
            'tafels' => $tafels,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reserveringen", name="reserveringen")
     */
    public function reserveringen()
    {
        $repo = $this->getDoctrine();

        $reservaties = $repo->getRepository(Reservatie::class)->findAll();

        return $this->render('default/reserveer_overzicht.html.twig', [
            'controller_name' => 'DefaultController',
            'reservaties' => $reservaties,
        ]);
    }

    /**
     * @Route("/reserveringen/{id}", name="bestellen", methods={"GET","POST"})
     */
    public function new(Request $request,Reservatie $reservatie ,$id): Response
    {
        $bestelling = new Bestelling();
        $datetime = new DateTime();

        $form = $this->createForm(BestelType::class, $bestelling);
        $form->handleRequest($request);

        $formData = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {

            $bestelling->setMenuItem($formData->getmenuItem());
            $bestelling->setBarman($formData->getbarman());
            $bestelling->setReservatie($reservatie);
            $bestelling->setDatum($datetime);
            $bestelling->setTijd($datetime);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bestelling);
            $entityManager->flush();

            $bestellingen = $reservatie->getBestellings();

            $totalMenu = 0;
            $totalDrank = 0;

            foreach($bestellingen as $menus) {
                if ($menus->getMenuItem() == null) {
                    $totalMenu = 0;
                } else {
                    $totalMenu += $menus->getMenuItem()->getPrijs();
                }
            }

            foreach($bestellingen as $dranken) {
                if ($dranken->getBarman() == null) {
                    $totalDrank = 0;
                } else {
                    $totalDrank += $dranken->getBarman()->getPrijs();
                }

            }

            $total = $totalMenu + $totalDrank;

            // Configure Dompdf according to your needs
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            // Instantiate Dompdf with our options
            $dompdf = new Dompdf($pdfOptions);
            // Retrieve the HTML generated in our twig file
            $html = $this->renderView('default/bon.html.twig', [
                'bestelling' => $bestelling,
                'bestellingen' => $bestellingen,
                'total' => $total,
            ]);
            // Load HTML to Dompdf
            $dompdf->loadHtml($html);
            // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
            $dompdf->setPaper('A4', 'portrait');
            // Render the HTML as PDF
            $dompdf->render();
            // Output the generated PDF to Browser (inline view)
            $dompdf->stream("mypdf.pdf", [
                "Attachment" => false
            ]);

            return $this->render('default/bestellen.html.twig', [
                'controller_name' => 'DefaultController',
                'bestelling' => $bestelling,
                'bestellingen' => $bestellingen,
            ]);
        }

        return $this->render('default/bestellen.html.twig', [
            'bestelling' => $bestelling,
            'reservatie' => $reservatie,
            'form' => $form->createView(),
        ]);
    }



}
