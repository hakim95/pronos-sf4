<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MatchsType;

class PronosController extends Controller
{
	/**
	 * @Route("/app/home", name="home")
	 */
	public function home()
	{
		$matchRepository = $this->getDoctrine()->getRepository('App\Entity\Matchs');
		$matchs = $matchRepository->findMatchesByGroupstages();

		$matchsByGroups = array();
		foreach($matchs as $index => $value){
			$matchsByGroups[$value['groupname']][$index] = array($value['matchname'], $value['results']); 
		}
		
		return $this->render('home.html.twig', array('matchs' => $matchsByGroups));
	}

	/**
	 * @Route("/app/resultat", name="new_resultat")
	 */
	public function resultat(Request $request)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$matchRepository = $this->getDoctrine()->getRepository('App\Entity\Matchs');
		$activeMatchesFromRepo = $matchRepository->findActiveMatches();
		$activeMatches = array();
		foreach ($activeMatchesFromRepo as $key => $matchs) {
			$activeMatches[$matchs['name']] = $matchs['id'];
		}

		$matchs = new \App\Entity\Matchs();
		$form = $this->createForm(MatchsType::class, $matchs, array('matchsOptions' => $activeMatches));

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$matchId = $form['name']->getData();
			$matchSelected = $matchRepository->find($matchId);
			$matchSelected->setResults($form['results']->getData());

			$entityManager->flush();

			$this->get('session')->getFlashBag()->add('confirm', 'Résultat ajouté!');

			return $this->redirectToRoute('new_resultat');
		}

		return $this->render('resultat.html.twig', array('form' => $form->createView()));
	}

	/**
	 * @Route("/app/pronos", name="pronos")
	 */
	public function pronos(Request $request)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$matchRepository = $this->getDoctrine()->getRepository('App\Entity\Matchs');
		$pronosticRepository = $this->getDoctrine()->getRepository('App\Entity\Pronostics');
		$activeMatchesFromRepo = $matchRepository->findActiveMatches();
		$activeMatches = array();
		foreach ($activeMatchesFromRepo as $key => $matchs) {
			$activeMatches[$matchs['name']] = $matchs['id'];
		}

		$matchs = new \App\Entity\Matchs();
		$pronostics = new \App\Entity\Pronostics();
		$form = $this->createForm(MatchsType::class, $matchs, array('matchsOptions' => $activeMatches));

		$form->handleRequest($request);

		$userId = $this->getUser()->getId();		
		$myPronos = $pronosticRepository->findPronosticsByUser($userId);

		if ($form->isSubmitted() && $form->isValid()) {
			$matchId = $form['name']->getData();
			$matchSelected = $matchRepository->find($matchId);
			$user = $this->getDoctrine()->getRepository('App\Entity\User')->find($userId);
			$resultat = $form['results']->getData();

			$pronostics->setContest($matchSelected);
			$pronostics->setScore($resultat);
			$pronostics->setPronouser($user);

			$entityManager->persist($pronostics);

			$entityManager->flush();

			$this->get('session')->getFlashBag()->add('confirm', 'Pronostic validé!');

			return $this->redirectToRoute('pronos');
		}

		return $this->render('pronos.html.twig', array('form' => $form->createView(), 'myPronos' => $myPronos));
	}
}