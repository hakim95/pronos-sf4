<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\MatchsType;

class PronosController extends Controller
{
	/**
	 * @Route("/app/home", options={"expose"=true}, name="home")
	 */
	public function home(Request $request)
	{
		$matchRepository = $this->getDoctrine()->getRepository('App\Entity\Matchs');

		if (!$request->isXmlHttpRequest()) {
			$matchs = $matchRepository->findMatchesByGroupstages();
			$nbhuitieme = $matchRepository->countHuitiemeMatches();
			$nbquart = $matchRepository->countQuartMatches();
			$nbdemi = $matchRepository->countDemiMatches();
			$nbfinale = $matchRepository->countFinaleMatch();	

			$matchsByGroups = array();
			foreach($matchs as $index => $value){
				$matchsByGroups[$value['groupname']][$index] = array($value['matchname'], $value['results']); 
			}
			
			return $this->render('home.html.twig', array(
				'matchs' => $matchsByGroups,
				'nbhuitieme' => $nbhuitieme[0]['nbhuitiemes'],
				'nbquart' => $nbquart[0]['nbquarts'],
				'nbdemi' => $nbdemi[0]['nbdemis'],
				'nbfinale' => $nbfinale[0]['nbfinale'],
			));
		} else {
			$step = $request->get('step');
			$matches = $matchRepository->findMatchesBySteps($step);

			$stepMatches = array();
			foreach ($matches as $index => $match) {
				$stepMatches['match-'.($index+1)] = array($match['matchname'], $match['results']);
			}

			dump($stepMatches);
			return new JsonResponse(array('matches' => $stepMatches));
		}
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