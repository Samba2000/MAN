<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $encoder;
    private $serializer;
    private $validator;
    private $em;
    private $userRepository;

    public function __construct(
        UserPasswordEncoderInterface $encoder,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        UserRepository $userRepository,
        EntityManagerInterface $em)
    {
        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->em=$em;
        $this->userRepository=$userRepository;
    }
    /**
     * @Route(
     *     name="addUser",
     *     path="/api/admin/users",
     *     methods={"POST"}
     * )
     *  @Route(
     *     name="addApprenant",
     *     path="/api/apprenants",
     *     methods={"POST"}
     * )
     */
    public function add(Request $request)
    {
        //recupéré tout les données de la requete
        $user = $request->request->all();
         
        //recupération de l'image
        $photo = $request->files->get("photo");

        if ($user['profil']=='/api/admin/profils/1')
        {
            $user = $this->serializer->denormalize($user,"App\Entity\User",true);
        }
        elseif ($user['profil']=='/api/admin/profils/2')
        {
            $user = $this->serializer->denormalize($user,"App\Entity\Formateur",true);
        }
        elseif ($user['profil']=='/api/admin/profils/3')
        {
            $user = $this->serializer->denormalize($user,"App\Entity\ComminutyManger",true);
        }else{
            $user = $this->serializer->denormalize($user,"App\Entity\Apprenant",true);
        }

        if(!$photo)
        {

            return new JsonResponse("veuillez mettre une images",Response::HTTP_BAD_REQUEST,[],true);
        }
            //$base64 = base64_decode($imagedata);
            $photoBlob = fopen($photo->getRealPath(),"rb");

             $user->setPhoto($photoBlob);

        $errors = $this->validator->validate($user);
        if (count($errors)){
            $errors = $this->serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }
        $password = $user->getPlainPassword();
       $user->setPassword($this->encoder->encodePassword($user,$password));
       $user->setArchivage(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        
        return $this->json($user,201);
     }
    /**
     * @Route(
     *     name="addUser",
     *     path="/api/admin/users/{id}",
     *     methods={"PUT"}
     * )
     */
    public function putUser(Request $request,$id)
    {
        //recupéré tout les données de la requete
        $user  =$this->userRepository->find($id);
        $usersall = $request->request->all();
        foreach ($usersall as $key => $value){
            if ($key !== "_method" || !$value){

                $user->{"set".ucfirst($key)}($value);
            }
        }
        //recupération de l'image
        $photo = $request->files->get("photo");

        $photoBlob = fopen($photo->getRealPath(),"rb");

        $user->setPhoto($photoBlob);
       $this->em->persist($user);
        $this->em->flush();

        return $this->json("success",201);
    }
}
