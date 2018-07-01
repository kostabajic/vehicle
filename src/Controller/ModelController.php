<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\VehicleType;
use App\Entity\Make;
use App\Entity\Model;
use App\Entity\SearchLog;
use Symfony\Component\HttpFoundation\JsonResponse;

class ModelController extends Controller
{


    /**
     * @Route("/model/show_import_model", name="show_import_model")
     */
    public function index() {
        return $this->render('model/import_model.html.twig');
    }


    /**
     * @Route("/models/{type}/{make_code}")
     * Method("POST")
     */
    public function getModelByVehicleTypeAndMake(Request $request,String $type,String $make_code) {
        //ajax call to return models  for selected option make in selelect
        $count_data=0;
        $repository = $this->getDoctrine()->getRepository(VehicleType::class);
        $vehicle_type = $repository->findOneBy(['code' => $type]);
        $vehicle_type_id=$vehicle_type->getId();
        $repositoryMake = $this->getDoctrine()->getRepository(Make::class);
        $make = $repositoryMake->findOneBy(['vehicle_type' =>$vehicle_type_id,'code' => $make_code]);
        $make_id=$make->getId();
        $repository = $this->getDoctrine()->getRepository(Model::class);
        $models = $repository->findByVehicleTypeAndMake($vehicle_type_id, $make_id);
        $jsonData=array();
        //insret in database searche_log 
        $count_data = count($models);
        $em = $this->getDoctrine()->getManager();
        $search_log = new SearchLog();
        $search_log->setVehicleType($type);
        $search_log->setMakeAbbr($make_code);
        $search_log->setRequestTime(new \DateTime());
        $search_log->setIpAddress($request->getClientIp());
        $search_log->setNumberOfModels($count_data);
        $search_log->setUserAgent($request->headers->get('User-Agent'));
        $em->persist($search_log);
        $em->flush();
        // create json response
        if ($count_data > 0)
            foreach ($models as $model) {
                $jsonData[] = ['id' => $model->getId(), 'code' =>$model->getCode(), 'description' => $model->getDescription()];
            } else
            $jsonData = -1;
        //response to ajax 
        $arrData = ['output' => $jsonData];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/model/import_model")
     * Method("POST")
     */
    public function import(Request $request) {
        $file = $request->files->get('fileImput');
        //if is right dokument import in database else redirect for new attempt
        if($file->getClientOriginalName()=="models.json"){
            $content = file_get_contents($file->getPathName(),true);
            $json = json_decode($content);
            $em = $this->getDoctrine()->getManager();
            $repository_vehicle_type = $this->getDoctrine()->getRepository(VehicleType::class);
            $repository_make = $this->getDoctrine()->getRepository(Make::class);
            $repository_model = $this->getDoctrine()->getRepository(Model::class);
            foreach ($json as $object_model) {
                $type=$object_model->type;
                $code=$object_model->code;
                $description=$object_model->description;
                if(trim($type)=="")
                    $type='No code';
                $vehicle_type = $repository_vehicle_type->findOneBy(['code' => $type]);
                // if vehicle_type don't exsist with this code in database insert vehicle_type
                if (!$vehicle_type) {
                    $vehicle_type = new VehicleType();
                    $vehicle_type->setCode($type);
                    $vehicle_type->setDescription('No name');
                    $em->persist($vehicle_type);
                    $em->flush();
                }
                $vehicle_type_id=$vehicle_type->GetId();
                if(trim($object_model->group)=='')
                    $object_model->group='No code';  
                $make = $repository_make->findOneBy(['vehicle_type' =>$vehicle_type_id,'code' => $object_model->group]);
                // if make don't exsist in database with this code and vehicle_typ insert make
                if (!$make) {
                    $make = new Make();
                    $make->setCode($object_model->group);
                    $make->setDescription('No name');
                    $make->setVehicleType($vehicle_type);
                    $em->persist($make);
                    $em->flush();
                }
                $make_id=$make->GetId();
                $model=$repository_model->findOneBy(['vehicle_type' =>$vehicle_type_id,'make' =>$make_id,'code' =>$code,'description' =>$description]);
                // if model exist don't duplicate
                if(!$model){
                    $model = new Model();
                    $model->setCode($code);
                    $model->setDescription($description);
                    $model->setVehicleType($vehicle_type);
                    $model->setMake($make);
                    $em->persist($model);
                    $em->flush(); 
                }
            }
            return $this->redirectToRoute('/');
        }else
            return $this->redirectToRoute('show_import_model');
    }
}
