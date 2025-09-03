<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\File;

class AccountController extends AbstractController
{
    #[Route('/account/{id}', name: 'app_account')]
    public function index(Request $request,
                          UserPasswordHasherInterface $userPasswordHasher,
                          EntityManagerInterface $entityManager, int $id,
                          SluggerInterface $slugger,
                          #[Autowire('%kernel.project_dir%/public/images/pfps')] string $profilesDirectory): Response
    {
//        Get the user from the database and add the data to the form
//        After submitting the form: hash the password and place the profile picture in the correct map
//        Then delete the old profile picture and submit the form
        $user = $entityManager->getRepository(User::class)->find($id);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('plainPassword')->getData() !==null) {
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }

            /** @var UploadedFile $profileFile */
            $profileFile = $form->get('profilePicture')->getData();

            // this condition is needed because the 'profilePicture' field is not required
            // so the file must be processed only when a file is uploaded
            if ($profileFile) {
                $originalFilename = pathinfo($profileFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$profileFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $profileFile->move($profilesDirectory, $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }


                if ($user->getProfilePicture() !== null) {
                    unlink($profilesDirectory.'/'.$user->getProfilePicture());
                }

                // updates the 'profilePicture' property to store the PDF file name
                // instead of its contents
                $user->setProfilePicture($newFilename);
//                $user->setProfilePicture($profilesDirectory.DIRECTORY_SEPARATOR.$user->getProfilePicture());
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }


        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'form' => $form,
        ]);
    }
}
