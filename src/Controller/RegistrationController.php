<?php
// src/Controller/RegistrationController.php
namespace App\Controller;
 
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
 
class RegistrationController extends Controller
{
    /**
     * @Route("/inscription", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        //$p= $_GET['p'];
        //dump($p).die;
        // création du formulaire
        $user = new User();
        // instancie le formulaire avec les contraintes par défaut, + la contrainte registration pour que la saisie du mot de passe soit obligatoire
        $form = $this->createForm(UserType::class, $user,[
           'validation_groups' => array('User', 'registration'),
        ]);
         
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
 
            // Encode le mot de passe
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            //generation du uniqid du parrain
            //$user->setNiveau(0);
            $user->setCle(uniqid());

            //dd($user);
            // Enregistre le membre en base
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', "Votre compte est enregistré.");
 
            return $this->redirectToRoute('connexion');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/c/{p}", name="p")
     */
    public function parrainage($p, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $cle = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneBy(['cle'=>$p]);
        //dd($cle);   

        $username = $cle->getUsername();
        $p = $request->attributes->get('_route_params');
        $uniqueCle= $cle->getCle();
        $uniqP = $p['p'];
        //dd($uniqueCle, $uniqP);

        //dd($p);

        if($uniqueCle===$uniqP){
             // création du formulaire
        $user = new User();    
        // instancie le formulaire avec les contraintes par défaut, + la contrainte registration pour que la saisie du mot de passe soit obligatoire
        $form = $this->createForm(UserType::class, $user,[
           'validation_groups' => array('User', 'registration'),
        ]);
         
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
 
            // Encode le mot de passe
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            //generation du uniqid du parrain
            
            $user->setCle(uniqid());
            $user->setAddby($username);
            $niveau=$cle->getNiveau();
            $niveauParrain=$user->setNiveau($niveau+1);
            
            $getNbrFilleul = $cle->getNbrFilleul();
            //dd($getNbrFilleul);
            $cle->setNbrFilleul($getNbrFilleul+1);
            //dd($niveauParrain);
            //dd($user);
            
            //dd($e);
            // Enregistre le membre en base
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', "Votre compte est enregistré.");
 
            return $this->redirectToRoute('connexion');
        }

        return $this->render(
            'registration/parrainage.html.twig',
            array('form' => $form->createView())
        );
        }else{
            return $this->render(
                'registration/error.html.twig',
            );
        }
       
    }
   

   
   
     
    
}
