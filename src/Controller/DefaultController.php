<?php

namespace App\Controller;



use App\Entity\Barman;
use App\Entity\MenuItem;
use App\Entity\Tafel;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\KlantRepository;
use App\Repository\BestellingRepository;

use App\Entity\Bestelling;
use App\Entity\Klant;
use App\Entity\Reservering;

use \DateTime;

use App\Form\ReserveerType;
use App\Form\MenuBestellingType;

use Dompdf\Dompdf;
use Dompdf\Options;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {

        $repo = $this->getDoctrine();
        $reserverings = $repo->getRepository(Reservering::class)->findAll();
        $tafels = $repo->getRepository(Tafel::class)->findAll();

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'reserverings' => $reserverings,
            'tafels' => $tafels,
        ]);
    }

    /**
     * @Route("/menukaart", name="menu")
     */
    public function menu()
    {
        $repo = $this->getDoctrine();

        $menuItems = $repo->getRepository(MenuItem::class)->findAll();
        $barmannen = $repo->getRepository(Barman::class)->findAll();

        return $this->render('default/menu.html.twig', [
            'controller_name' => 'DefaultController',
            'menuItems' => $menuItems,
            'barmannen' => $barmannen,
        ]);
    }

    /**
     * @Route("/reserveer", name="reserveer")
     */
    public function reserveer(Request $request) : Response
    {

        $form = $this->createForm(ReserveerType::class);
        $form->handleRequest($request);

        $date = new DateTime();
        $reservering = new Reservering();

        $formData = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {

            $reservering->setNaam($formData->getNaam());
            $reservering->setDatum($date);
            $reservering->setTime($date);
            $reservering->setKlant($formData->getKlant());
            $reservering->setTafel($formData->getTafel());

            $reservering->getTafel()->setGereserveerd(1);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservering);
            $entityManager->flush();

            return $this->redirectToRoute('reserveer-bestel');
        }

        return $this->render('default/reserveer.html.twig', [
            'controller_name' => 'DefaultController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reserveer/bestellen", name="reserveer-bestel")
     */
    public function reserveer_bestellen()
    {
        $reserverings = $this->getDoctrine()->getRepository(Reservering::class)->findAll();

        return $this->render('default/reservering_bestellen.html.twig', [
            'controller_name' => 'DefaultController',
            'reserverings' => $reserverings,
        ]);
    }

    /**
     * @Route("/reserveer/bestellen/{id}", name="bestel")
     */
    public function bestel(Reservering $reservering, Request $request, $id) :response
    {

        $form = $this->createForm(MenuBestellingtype::class);
        $form->handleRequest($request);
        $formData = $form->getData();

        $datetime = new DateTime();
        $bestelling = new Bestelling();
        $bestelling_producten = $this->getDoctrine()->getRepository(Bestelling::class)->findBy(['id' => $id]);

        if ($form->isSubmitted() && $form->isValid()) {

            $bestelling->setMenuItem($formData->getMenuItem());
            $bestelling->setBarman($formData->getBarman());
            $bestelling->setDatum($datetime);
            $bestelling->setTime($datetime);
            $bestelling->setReservering($reservering);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bestelling);
            $entityManager->flush();

            $reserveringBestellingen = $reservering->getBestellings();
//
//            $menus = 0;
//            $dranken = 0;

            $total = 0;

            foreach($reservering->getBestellings() as $test){
                $total += $test->getMenuItem()->getPrijs();
//                $total += $test->getBarman()->getPrijs();
            }

            // Configure Dompdf according to your needs
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            // Instantiate Dompdf with our options
            $dompdf = new Dompdf($pdfOptions);
            // Retrieve the HTML generated in our twig file
            $html = $this->renderView('default/bon.html.twig', [
                'bestelling' => $bestelling,
                'bestelling_producten' => $bestelling_producten,
                'total' => $total,
                'reserveringBestellingen' => $reserveringBestellingen,
            ]);
            // Load HTML to Dompdf
            $dompdf->loadHtml($html);
            // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
            $dompdf->setPaper('A4', 'portrait');
            // Render the HTML as PDF
            $dompdf->render();
            // Output the generated PDF to Browser (force download)
            $dompdf->stream("mypdf.pdf", [
                "Attachment" => false
            ]);


            return $this->render('default/bon.html.twig', [
                'controller_name' => 'DefaultController',
                'bestelling' => $bestelling,
                'bestelling_producten' => $bestelling_producten,
            ]);
        }

        return $this->render('default/bestel.html.twig', [
            'controller_name' => 'DefaultController',
            'reservering' => $reservering,
            'form' => $form->createView(),
        ]);
    }

}
