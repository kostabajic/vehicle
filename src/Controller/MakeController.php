<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\VehicleType;
use App\Entity\Make;
use App\Entity\Model;

class MakeController extends Controller
{
    /**
     * @Route("/makes/{type}", name="makes")
     */
    public function getMakeByVehicleType(String $type) {
        $repository = $this->getDoctrine()->getRepository(VehicleType::class);
        $vehicle_type = $repository->findOneBy(['code' => $type]);
        $vehicle_type_id=$vehicle_type->getId();
        $repository_make = $this->getDoctrine()->getRepository(Make::class);
        $makes = $repository_make->findByVehicleType($vehicle_type_id);  
        $model_count=array();
        foreach ($makes as $make){
            $make_id=$make->getId();
            $repository_model = $this->getDoctrine()->getRepository(Model::class);
            $models=$repository_model->findByVehicleTypeAndMake($vehicle_type_id,$make_id );
            if($models)
                $model_count[$make_id]=count($models);
            else
                $model_count[$make_id]=0;
        }
        return $this->render('make/makes_by_vehicle_type.html.twig', array("makes" => $makes, "type" => $type, "model_count" => $model_count));
    }

    /**
     * @Route("/make/show_import_make" , name="show_import_make")
     */
    public function import() {
        return $this->render('make/import_make.html.twig');
    }

    /**
     * @Route("/make/import_make")
     * Method("POST")
     */
    public function importData(Request $request) {
        $file = $request->files->get('fileImput');
        if($file->getClientOriginalName()=="makes.json"){
            $content = file_get_contents($file->getPathName(), true);
            $json = json_decode($content);
            $em = $this->getDoctrine()->getManager();
            $repository_vehicle_type = $this->getDoctrine()->getRepository(VehicleType::class);
            $repository_make = $this->getDoctrine()->getRepository(Make::class);
            foreach ($json as $object_make) {
                $vehicle_type_code=$object_make->type;
                if(trim($vehicle_type_code)=='')
                    $vehicle_type_code='No code';
                $vehicle_type = $repository_vehicle_type->findOneBy(['code' => $vehicle_type_code]);
                if (!$vehicle_type) {
                    $vehicle_type = new VehicleType();
                    $vehicle_type->setCode($vehicle_type_code);
                    $vehicle_type->setDescription('No name');
                    $em->persist($vehicle_type);
                }
                $make=$repository_make->findOneBy(['vehicle_type' =>$vehicle_type->GetId(),'code' =>$object_make->code,'description' =>$object_make->description]);
                if(!$make){
                    $make = new Make();
                    $make->setCode($object_make->code);
                    $make->setDescription($object_make->description);
                    $make->setVehicleType($vehicle_type);
                    $em->persist($make);
                    $em->flush();
                }

            }
            return $this->redirectToRoute('show_import_model');
        }else
            return $this->redirectToRoute('show_import_make');
    }
}
