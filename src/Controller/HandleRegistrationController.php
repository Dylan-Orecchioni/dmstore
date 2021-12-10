<?php 

namespace App\Controller;

use App\Entity\User;
use App\Entity\Adress;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HandleRegistrationController extends AbstractController
{
    /**
     * @Route("/register/user", name="register_user")
     *
     */
    public function handleRegister(Request $request,UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {
        $user = new User()  ;     
        $formRegister = $this->createForm(RegistrationFormType::class,$user);

        $formRegister->handleRequest($request);

        if($formRegister->isSubmitted() && $formRegister->isValid())
        {
            if ($formRegister->isSubmitted() && $formRegister->isValid()) {
                // encode the plain password
        
       
                $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $formRegister->get('plainPassword')->getData()
                    )
                );
    
                $entityManager->persist($user);
                
                $address = new Adress();
                $address->setUser($user);
                $address->setAdress($formRegister->get("adress")->getData());
                $address->setCp($formRegister->get("cp")->getData());
                $address->setCity($formRegister->get("city")->getData());
    
                $entityManager->persist($address);
    
                $entityManager->flush();
                // do anything else you need here, like send an email
    
                return $this->redirectToRoute('app_login');
            }
        }
    }
}