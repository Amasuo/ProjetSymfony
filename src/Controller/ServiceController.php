<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Doctor;
use App\Entity\Speciality;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ServiceController extends AbstractController
{
    /**
     * @Route("/services/search/{name}", name="search_service")
     */
    public function Search($name, Request $request):Response
    {
      // affichage des docteurs d'un façon dynamique (sans "refresh" de la page)

      $entityManager = $this->getDoctrine()->getManager();
      $speciality = $entityManager->getRepository(Speciality::class)->findBy(['name' => $name]);
      foreach ($speciality as $var) {
        $temp = $var->getId();
      }
      $listDoctors = $entityManager->getRepository(Doctor::class)->findBy(['speciality' =>$temp]);

      $encoders = [new JsonEncoder()];
      $normalizers = [(new ObjectNormalizer())->setIgnoredAttributes(['id','speciality','phone','email','b','image'])];
      $serializer = new Serializer($normalizers, $encoders);
      $data = $serializer->serialize($listDoctors, 'json',[
        'circular_reference_handler' => function ($object) {
          return $object->getId();
        }
      ]);

        return $this->json(['code' => 200 , 'message' => 'search works!', 'listDoctors' =>$data],200);
    }
}
