<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card")
     */
    public function card(): Response
    {
        return $this->render('card/card.html.twig');
    }

    /**
     * @Route("/card/deck", name="showDeck")
     */
    public function showDeck(): Response
    {
        $deck = new \App\Card\Deck();
        $data = [
            'title' => 'Deck',
            'deck' => $deck->getDeck(),
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck2", name="showDeck2")
     */
    public function showDeck2(): Response
    {
        $deck = new \App\Card\DeckWith2Jokers();
        $data = [
            'title' => 'Deck with jokers',
            'deck' => $deck->getDeck(),
        ];
        return $this->render('card/deck2.html.twig', $data);
    }

    /**
     * @Route("/card/deck/shuffle", name="shuffleDeck")
     */
    public function shuffleDeck(
        SessionInterface $session
    ): Response {
        $session->remove("drawDeck");
        $session->remove("dealDeck");
        $deck = new \App\Card\Deck();

        $data = [
            'title' => 'Deck',
            'deck' => $deck->shuffleDeck(),
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck/reset",
     * name="reset",
     * methods={"GET","POST", "HEAD"})
     */
    public function resetSessionDeck(SessionInterface $session)
    {
        $session->set("drawDeck", new \App\Card\Deck());
        return $this->redirectToRoute('card');
    }

    /**
     * @Route(
     *      "/card/deck/draw",
     *      name="draw-card",
     *      methods={"GET","POST"}
     * )
     */
    public function drawCard(
        SessionInterface $session
    ): Response {
        $drawDeck = $session->get("drawDeck") ?? new \App\Card\Deck();

        $cardDrawed = $drawDeck->draw();
        $data = [
            'cards' => $cardDrawed,
            'left' => count($drawDeck->getDeck()),
        ];
        $session->set("drawDeck", $drawDeck);

        return $this->render('card/draw.html.twig', $data);
    }

    /**
     * @Route(
     *      "/card/deck/draw/{numberCards}",
     *      name="draw-card-number",
     *      methods={"GET","POST"}
     * )
     */
    public function drawCardNumber(
        int $numberCards,
        SessionInterface $session
    ): Response {
        $drawDeck = $session->get("drawDeck") ?? new \App\Card\Deck();

        if (count($drawDeck->getDeck()) >= $numberCards) {
            $cardDrawed = $drawDeck->draw($numberCards);
        } else {
            $cardDrawed = $drawDeck->draw(count($drawDeck->getDeck()));
        }

        $data = [
            'cards' => $cardDrawed,
            'left' => count($drawDeck->getDeck()),
        ];
        $session->set("drawDeck", $drawDeck);

        return $this->render('card/draw.html.twig', $data);
    }

    /**
     * @Route(
     *      "/card/deck/deal/{players}/{cards}",
     *      name="deal-cards",
     *      methods={"GET","POST"}
     * )
     */
    public function dealCards(
        int $players,
        int $cards,
        SessionInterface $session
    ): Response {
        $playerArray = array();
        for ($x = 1; $x <= $players; $x++) {
            $player = new \App\Card\Player($x);
            array_push($playerArray, $player);
        };

        $dealDeck = $session->get("dealDeck") ?? new \App\Card\Deck();
        $counter = 0;
        while ($counter < $cards) {
            foreach ($playerArray as $playerSingle) {
                if (count($dealDeck->getDeck()) > 0) {
                    $playerSingle->addToHand($dealDeck->draw()[0]);
                };
            };
            $counter++;
        };
        $data = [
            'players' => $playerArray,
            'left' => count($dealDeck->getDeck()),
        ];

        $session->set("dealDeck", $dealDeck);

        return $this->render('card/deal.html.twig', $data);
    }
}
