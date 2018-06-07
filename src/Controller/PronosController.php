<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PronosController extends Controller
{
	/**
	 * @Route("/pronos", name="pronos")
	 */
	public function pronos()
	{
		$matchRepository = $this->getDoctrine()->getRepository('App\Entity\Matchs');
		$matchs = $matchRepository->findAll();

		return $this->render('pronos.html.twig', array('matchs' => $matchs));
	}
}