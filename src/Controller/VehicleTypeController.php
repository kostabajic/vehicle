<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\VehicleType;
use App\Entity\Make;

class VehicleTypeController extends Controller
{
    /**
     * @Route("/", name="/")
     */
    public function index() {
        $make_counts=array();
        $repository_vehicle_type = $this->getDoctrine()->getRepository(VehicleType::class);
        $vehicle_types = $repository_vehicle_type->findAll();
        // if data isn't imported redirect to import else show vehicle_type with number of makes
        if(!$vehicle_types)
            return $this->redirectToRoute('show_import_vehicle_type');
        $repository_make = $this->getDoctrine()->getRepository(Make::class);
        foreach($vehicle_types as $vehicle_type){
            $makes = $repository_make->findByVehicleType($vehicle_type->getId());
            $make_counts[$vehicle_type->getId()]=count($makes);  
        }
        return $this->render('vehicle_type/index.html.twig', array("vehicle_types" => $vehicle_types,"make_counts"=>$make_counts));
    }

    /**
     * @Route("/vehicle_type/show_import_vehicle_type", name="show_import_vehicle_type")
     */
    public function import() {
        return $this->render('vehicle_type/import_vehicle_type.html.twig');
    }

    /**
     * @Route("/vehicle_type/import_vehicle_type")
     * Method("POST")
     */
    public function importData(Request $request) {
        $file = $request->files->get('fileImput');
        //if is right dokument import in database else redirect for new attempt
        if($file->getClientOriginalName()=="vehicle_types.json"){
           $content = file_get_contents($file->getPathName(), true);
            $json = json_decode($content);
            $em = $this->getDoctrine()->getManager();
            $repository_vehicle_type= $this->getDoctrine()->getRepository(VehicleType::class);
            foreach ($json as $object_vehicle_type) {
                $code=$object_vehicle_type->code;
                $description=$object_vehicle_type->description;
                $vehicle_type=$repository_vehicle_type->findBy(["code"=>$code,"description"=>$description]);
                // if vehicle_type don't exsist with this code in database insert vehicle_type 
                if(!$vehicle_type){
                    $vehicle_type = new VehicleType();
                    $vehicle_type->setCode($code);
                    $vehicle_type->setDescription($description);
                    $em->persist($vehicle_type);
                    $em->flush();
                }       
            }
                return $this->redirectToRoute('show_import_make');
        }else
            return $this->redirectToRoute('show_import_vehicle_type');             
    }

}
