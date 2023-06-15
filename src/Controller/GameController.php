<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/play/', name: 'app_game_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $response = new Response($this->renderView('sudoku/index.html.twig'), 200);
        $response->headers->setCookie($this->recreateAnonymousUserCookie($request));

        return $response;
    }

    private function recreateAnonymousUserCookie(Request $request): Cookie
    {
        $cookieName = $this->getParameter('app.anonymous_user_cookie.name');

        return new Cookie(
            $cookieName,
            $request->cookies->get($cookieName) ?? md5(rand() . time()),
            time() + $this->getParameter('app.anonymous_user_cookie.duration')
        );
    }
}