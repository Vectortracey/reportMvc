<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\Game;
use App\Card\Player;
use App\Card\Deck;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="intro")
     */
    public function game(): Response
    {
        return $this->render('game/intro.html.twig');
    }

    /**
     * @Route("/game/doc", name="doc")
     */
    public function gameDoc(): Response
    {
        return $this->render('game/doc.html.twig');
    }

    /**
     * @Route("/game/start", name="start")
     */
    public function gameStart(SessionInterface $session): Response
    {
        $session->remove("game");
        $game = new Game();

        $session->set("game", $game);

        return $this->render('game/start.html.twig');
    }

    /**
     * @Route("/game/draw", name="draw")
     */
    public function gameDraw(SessionInterface $session): Response
    {
        $game = $session->get("game");
        $game->drawCardPlayer();
        $cardHand = $game->getHandPlayer();
        $sum = $game->getSum();
        $data = [
            'winner' => $game->getWinner(),
            'sumPlayer' => $sum[0],
            'cardHand' => $cardHand
        ];

        $session->set("game", $game);

        if ($sum[0] > 21) {
            return $this->redirectToRoute('game-stop');
        }
        return $this->render('game/draw.html.twig', $data);
    }

    /**
     * @Route("/game/stop", name="stop")
     */
    public function gameStop(SessionInterface $session): Response
    {
        $game = $session->get("game");
        $cardHand = $game->getHandBank();
        $cardHandPlayer = $game->getHandPlayer();
        $sum = $game->getSum();
        $game->setWinner();
        $data = [
            'winner' => $game->getWinner(),
            'sumBank' => $sum[1],
            'sumPlayer' => $sum[0],
            'cardHandBank' => $cardHand,
            'cardHand' => $cardHandPlayer
        ];

        $session->set("game", $game);
        return $this->render('game/stop.html.twig', $data);
    }
}
