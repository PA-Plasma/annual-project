<?php

namespace App\Controller\Modules;

use App\Controller\Interfaces\ModuleInterface;
use App\Entity\Entrant;
use App\Entity\Event;
use App\Entity\Modules\ModuleTournament;
use App\Entity\Modules\ModuleTournamentMatch;
use App\Entity\Modules\ModuleTournamentMatchScore;
use App\Entity\Modules\ModuleTournamentParameters;
use App\Form\ModuleTournamentParametersType;
use App\Service\Modules\ModuleTournamentHelper;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TournoiModuleController
 * @package App\Controller\Modules
 */
Class TournamentModuleController extends AbstractController implements ModuleInterface
{
    protected $tournamentHelper;

    public function __construct(ModuleTournamentHelper $helper)
    {
        $this->tournamentHelper = $helper;
    }

    /**
     * @param Event $event
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/event/{slug}/tounament-parameters", name="module_tournament_parameters", methods={"GET","POST"})
     */
    public function parameters(Event $event, Request $request)
    {
        $moduleTournoi = $event->getModuleTournament();
        if ($moduleTournoi->getModuleTournamentParameters() !== null) {
            $moduleTournoiParameters = $moduleTournoi->getModuleTournamentParameters();
        } else {
            $moduleTournoiParameters = new ModuleTournamentParameters();
            $moduleTournoiParameters->setModuleTournament($moduleTournoi);
        }
        $form = $this->createForm(ModuleTournamentParametersType::class, $moduleTournoiParameters, [
            'action' => $this->generateUrl('module_tournament_parameters', ['slug' => $event->getSlug()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($moduleTournoiParameters);
            $entityManager->flush();
            return $this->redirectToRoute('front_event_show', ['slug' => $event->getSlug()]);
        }

        return $this->render('Modules/ModuleTournament/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'moduleTournoi' => $moduleTournoi,
            'name' => 'Tournament',
            'ajax' => (($request->getMethod() === 'GET') ? false : true)
        ]);
    }

    /**
     * @param Event $event
     * @param Request $request
     * @Route(name="module_tournament_show", path="/event/{slug}/tournament-show")
     */
    public function display(Event $event, Request $request)
    {
        $rounds = $this->tournamentHelper->getRounds($event->getModuleTournament());
        $winner = $this->tournamentHelper->getTournamentWinner($event->getModuleTournament());
        return $this->render("Modules/ModuleTournament/show.html.twig", ['event' => $event, 'rounds' => $rounds, 'winner' => $winner]);
    }

    /**
     * @param ModuleTournament $tournament
     * @param ModuleTournamentHelper $moduleTournamentHelper
     * @Route(name="module_tournament_init_matches", path="/tournament/{id}/create-matches")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function initMatches(ModuleTournament $tournament, ModuleTournamentHelper $moduleTournamentHelper)
    {
        $i = 1;
        try {
            foreach ($tournament->getEvent()->getEntrants() as $joueur) {
                if ($i === 1) {
                    $match = $moduleTournamentHelper->newMatch($tournament);
                }
                $match->addPlayer($joueur);
                if ($i === 2) {
                    $this->getDoctrine()->getManager()->persist($match);
                    $this->getDoctrine()->getManager()->flush();
                    $i = 1;
                } else {
                    $i++;
                }
            }
        } catch (NonUniqueResultException $e) {
            $this->addFlash('error', $e->getMessage());
        }
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('front_event_show', ['slug' => $tournament->getEvent()->getSlug()]);
    }

    /**
     * @param ModuleTournamentMatch $match
     * @param Request $request
     * @param ModuleTournamentHelper $tournamentHelper
     * @return JsonResponse
     * @Route(name="module_tournament_score", path="/tournament/add-score/{id}")
     */
    public function addScore(ModuleTournamentMatch $match, Request $request, ModuleTournamentHelper $tournamentHelper)
    {
        $datas = $request->request->get('score');
        $datas = json_decode($datas, true);
        $em = $this->getDoctrine()->getManager();
        foreach ($datas as $item) {
            if ($item['score_id'] === null) {
                $player = $em->getRepository(Entrant::class)->find($item['player_id']);
                $score = new ModuleTournamentMatchScore();
                $score->setMatch($match)
                    ->setPlayer($player);
                $em->persist($score);
            } else {
                $score = $em->getRepository(ModuleTournamentMatchScore::class)->find($item['score_id']);
            }
            $score->setScore($item['score']);
        }
        $em->flush();
        //si tous les matchs ont un score, on lance un nouveau round
        $tournament = $match->getTournament();
        $valid = true;
        foreach ($tournament->getMatches() as $matchTournament) {
            if (count($matchTournament->getPlayers()) !== count($matchTournament->getScores())) {
                $valid = false;
            }
        }
        $nextRound = $em->getRepository(ModuleTournamentMatch::class)->findBy(['round' => $match->getRound() + 1, 'tournament' => $match->getTournament()]);
        if ($valid && $tournamentHelper->getTournamentWinner($tournament) === null && empty($nextRound)) {
            //new round
            try {
                $round = $match->getRound();
                //recupération des joueurs gagnant du round précédent
                $oldMatches = $em->getRepository(ModuleTournamentMatch::class)->findBy(['tournament' => $tournament, 'round' => $round]);
                $i = 1;
                $count = 0;
                $round++;
                $match = $tournamentHelper->newMatch($tournament, $round);
                foreach ($oldMatches as $om) {
                    $count++;
                    $winner = $tournamentHelper->getMatchWinner($om);
                    $match->addPlayer($winner);
                    if ($i === 2) {
                        $em->flush();
                        if ($count !== count($oldMatches)) {
                            $match = $tournamentHelper->newMatch($tournament, $round);
                            $em->persist($match);
                        }
                        $i = 1;
                    } else {
                        $i++;
                    }
                }
            } catch (NonUniqueResultException $e) {
                return new JsonResponse(['etat' => 'error', 'message' => $e->getMessage()]);
            }
        }
        $em->flush();
        return new JsonResponse(['etat' => 'success', 'message' => 'ok']);
    }
}