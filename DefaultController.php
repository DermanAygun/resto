<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Customer;

use App\Form\new_appointmentType;
use App\Form\new_customerType;

use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormBuilderInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/afspraak-maken", name="new_appointment", methods={"GET","POST"})
     */
    public function afspraak_maken(Request $request): Response
    {
        $form = $this->createForm(new_appointmentType::class);
        $form->handleRequest($request);

        $appointment = new Appointment();
        $customer = new Customer();

        $formData = $form->getData();

        $customer_name = $formData['name'];
        $customer_phone = $formData['phone'];
        $customer_email = $formData['email'];

        $barber_name = $formData['barber'];
        $treatment_name = $formData['treatment'];
        $appointment_date = $formData['date'];
        $appointment_time = $formData['time'];

        if ($form->isSubmitted() && $form->isValid()) {

            if(!$customer_phone && !$customer_email) {
                echo "not allowed";
            } else {
                $customer->setName($formData['name']);
                $customer->setPhone($formData['phone']);
                $customer->setEmail($formData['email']);

                $appointment->setDate($formData['date']);
                $appointment->setTime($formData['time']);
                $appointment->setBarberId($formData['barber']);
                $appointment->setTreatmentId($formData['treatment']);
                $appointment->setCustomerId($customer);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($appointment);
                $entityManager->persist($customer);
                $entityManager->flush();

                return $this->render('default/show_appointment.html.twig', [
                    'controller_name' => 'DefaultController',
                    'form' => $form->createView(),
                    'customer_name' => $customer_name,
                    'customer_phone' => $customer_phone,
                    'customer_email' => $customer_email,

                    'barber_name' => $barber_name,
                    'treatment_name' => $treatment_name,
                    'appointment_date' => $appointment_date,
                    'appointment_time' => $appointment_time,
                ]);
            }
        }

        return $this->render('default/new_appointment.html.twig', [
            'controller_name' => 'DefaultController',
            'form' => $form->createView(),
        ]);


    }
}
