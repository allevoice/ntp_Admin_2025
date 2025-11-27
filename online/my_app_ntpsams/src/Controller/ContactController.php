<?php

namespace App\Controller;

use App\Model\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route(path: '/{_locale}',requirements: ['_locale' => '%app.locales%'],name: 'app_contact_',defaults: ['_locale' => '%app.default_locale%'])]
class ContactController extends AbstractController
{

    private const MAX_LENGTH = 200;


    #[Route('/contact', name: 'form')]
    public function index(): Response
    {
        // La variable MAX_LENGTH est maintenant injectée directement dans le template.
        $vars = [
            'name_value' => '',
            'email_value' => '',
            'subject_value' => '',
            'message_value' => '',
            // Inclus ici pour le template Twig
            'max_length' => self::MAX_LENGTH,
        ];

        //dd($appSecret = $this->getParameter('kernel.secret'));
        return $this->render('contact/index.html.twig', [
            'title_page' => 'Contact',
            'controller_name' => 'HomeController',
            'form_vars' => $vars,
            'errors' => [],
            'success_messages' => [
                'name' => 'Nom vérifié.',
                'email' => 'E-mail vérifié.',
                'subject' => 'Sujet OK.',
                'message' => 'Message OK.',],
        ]);
    }


    #[Route('/contact/send', name: 'send_form')]
    public function sendmail(Request $request,Contact $contact): Response
    {

        $postData = $request->request->all();

        $errors = [];

        $vars = [
            'name_value' => trim($postData['name'] ?? ''),
            'email_value' => trim($postData['email'] ?? ''),
            'subject_value' => trim($postData['subject'] ?? ''),
            'message_value' => trim($postData['message'] ?? ''),
            // Inclus ici pour le template Twig en cas d'erreur
            'max_length' => self::MAX_LENGTH,
        ];

        // --- Validation ---
        if (empty($vars['name_value'])) {
            $errors['name'] = 'Please enter your full name';'//Veuillez entrer votre nom.';
        }
        if (empty($vars['email_value']) || !filter_var($vars['email_value'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';//'Veuillez entrer une adresse e-mail valide.';
        }
        if (empty($vars['subject_value'])) {
            $errors['subject'] = 'Le sujet est obligatoire';//'Le sujet est obligatoire.';
        }

        // Utilisation de la constante pour la validation
        if (empty($vars['message_value'])) {
            $errors['message'] = 'Please write a message';//'Veuillez écrire un message.';
        } elseif (mb_strlen($vars['message_value']) > self::MAX_LENGTH) {
            //$errors['message'] = "Le message est trop long. Il doit contenir au maximum " . self::MAX_LENGTH . " caractères.";
			$errors['message'] = "The message is too long. It must contain a maximum of " . self::MAX_LENGTH . " characters.";
        
		}

        // --- Traitement ---
        if (empty($errors)) {
            try {
                // LOGIQUE D'ENREGISTREMENT ET D'ENVOI D'EMAIL


                $contact->setFullname($vars['name_value']);
                $contact->setEmail($vars['email_value']);
                $contact->setSubject($vars['subject_value']);
                $contact->setContent($vars['message_value']);
                $contact->insert();

//                if($contact->mail_info_send_no_attachment($mail_fullname,$mail_sender,$mail_subject,$message)){
                if($contact->mail_info_send_no_attachment($vars['name_value'],$vars['email_value'],$vars['subject_value'],$vars['message_value'])){
                    
					//$global_success = 'Votre message a été enregistré avec succès. Merci !';
					$global_success = 'Your message has been successfully recorded. Thank you!';
                    // Réinitialiser les champs après succès

                    //$this->addFlash('success', 'Votre message a été enregistré avec succès. Merci !');
                    $this->addFlash('success', 'Your message has been sent successfully. Thank you!');
                    return $this->redirectToRoute('app_contact_form');
                }





            } catch (\Exception $e) {
                //$this->addFlash('error', 'Erreur critique : Échec de l\'enregistrement. Veuillez réessayer.');
                $this->addFlash('error', 'Critical error: Sending failed. Please try again.');
            }
        } else {
            //$this->addFlash('warning', 'Veuillez corriger les erreurs dans le formulaire.');
            $this->addFlash('warning', 'Please correct any errors in the form.');

            // Retourne le formulaire avec les erreurs et les données conservées
            return $this->render('contact/form.html.twig', [
                'form_vars' => $vars,
                'errors' => $errors,
                'success_messages' => [
                    'name' =>  'Full ame verified.',//'Nom vérifié.',
                    'email' => 'Email verified.',//'E-mail vérifié.',
                    'subject' => 'Subject OK.',//'Sujet OK.',
                    'message' => 'Message OK.',//'Message OK.',
                ],
            ]);
        }

        return $this->redirectToRoute('app_contact_form');
    }


}
