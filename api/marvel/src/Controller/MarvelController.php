<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

class MarvelController extends AbstractController
{
	/**
	 * [getCharactersList description]
	 * @Route("/getCharactersList", methods={"GET"})
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function getCharactersList(Request $request)
	{
		$offset = $request->query->get('offset');
		$offset = $offset == null ? 100 : $offset;
		$limit = $request->query->get('limit');
		$limit = $limit == null ? 20 : $limit;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://gateway.marvel.com/v1/public/characters?ts=1&apikey=5f9fafa4c65f4c31bc15b9301203835f&hash=c2376eedba988967c6a18a5f9bc4d41a&offset=".$offset."&limit=".$limit,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json",
		    // "Postman-Token: 2b52b08b-3b33-4d62-bace-92e9e218d428",
		    "cache-control: no-cache"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {

			//We select only the required fields for the returned reponse
	  		$json = json_decode($response);
			$heroes = $json->data->results;

			$lightResponse = [];
			foreach ($heroes as $hero) {
				$lightHero['id'] = $hero->id;
				$lightHero['name'] = $hero->name;
				$lightHero['description'] = $hero->description;
				$lightHero['path'] = $hero->thumbnail->path;
				$lightHero['extension'] = $hero->thumbnail->extension;

				$result[] = $lightHero;
			}
  			return new Response(json_encode($result));
		}
	}


	/**
	 * @Route("/getThreeFirstComicsByCharacterId", methods={"GET"})
	 */
	public function getThreeFirstComicsByCharacterId(Request $request)
	{
		if ( ($heroId = $request->query->get('id') ) !== null)
		{
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_PORT => "443",
			  CURLOPT_URL => "https://gateway.marvel.com:443/v1/public/characters/".$heroId."/comics?format=comic&formatType=comic&orderBy=onsaleDate&limit=3&ts=1&apikey=5f9fafa4c65f4c31bc15b9301203835f&hash=c2376eedba988967c6a18a5f9bc4d41a",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_POSTFIELDS => "",
			  CURLOPT_HTTPHEADER => array(
			    "Content-Type: application/json",
			    // "Postman-Token: 7a5f1dc6-5df7-4ea2-8da8-c5ac66cbe7d7",
			    "cache-control: no-cache"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  	//echo $response;
			  	//SELECT ONLY IMPORTANT FIELDS FOR JS RETURN
		  		return new Response($response);
			}
		}
		else
		{
			return new JsonResponse(["nope" => "bug"]);
		}
	}


	/**
	 * @Route("/GetById", methods={"GET"})
	 */
	public function getCharacterById(Request $request)
	{
		if ( ($heroId = $request->query->get('id') ) !== null)
		{
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://gateway.marvel.com/v1/public/characters/".$heroId."?ts=1&apikey=5f9fafa4c65f4c31bc15b9301203835f&hash=c2376eedba988967c6a18a5f9bc4d41a",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_POSTFIELDS => "",
			  CURLOPT_HTTPHEADER => array(
			    "Content-Type: application/json",
			    //"Postman-Token: 6b6be701-f7e2-4067-8789-3af04bc6c9c4",
			    "cache-control: no-cache"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  	echo "cURL Error #:" . $err;
			} else {
			  	//echo $response;
			  	//SELECT ONLY IMPORTANT FIELDS FOR JS RETURN
		  		return new Response($response);
			}
		}
		else
		{
			return new JsonResponse(["nope" => "bug"]);
		}
	}



	
	
	
	// /**
 //     * @Route("/GetById", name="getheroById")
 //     */
 //    public function GetById()
 //    {
	// 	return new JsonResponse([
 //            [
 //                'title' => 'The Princess Brides',
 //                'count' => 0
 //            ]
 //        ]);
 //    }




	//*********************************************************************
	//
	
    /**
     * @Route("/marvel", name="marvel")
     */
    public function index()
    {
        return $this->render('marvel/index.html.twig', [
            'controller_name' => 'MarvelController',
        ]);
    }


     /**
     * @Route("/mouais", name="mouais")
     */
    public function mouais()
    {
		return new JsonResponse([
            [
                'title' => 'The Princess Brides',
                'count' => 0
            ]
        ]);
    }

     /**
     * @Route("/test", name="test")
     */
    public function test()
    {
    	$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://gateway.marvel.com/v1/public/characters?ts=1&apikey=5f9fafa4c65f4c31bc15b9301203835f&hash=c2376eedba988967c6a18a5f9bc4d41a&offset=100&limit=20",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json",
		    //"Postman-Token: b3e60971-24b9-4265-9f1b-6e1e7ca2d728",
		    "cache-control: no-cache"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  return new Response($response);
		  //return new JsonResponse([$response]);
		}
    }
}
