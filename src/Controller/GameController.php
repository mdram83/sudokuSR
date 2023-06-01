<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/play/', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $content = $this->renderView('sudoku/index.html.twig');
        $response = new Response($content, 200);

        // TODO set cookie name in config for bellow and in AjaxLoadGameController

        if (!$request->cookies->get('ANONYMOUS_USER')) {
            $response->headers->setCookie(new Cookie(
                'ANONYMOUS_USER',
                md5(rand().time()),
                time() + 2 * 24 * 3600
            ));
        }

        return $response;

    }
}