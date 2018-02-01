<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController Extends Controller
{
    /**
     * @Route("/word/", name="app_word")
     */
    public function wordOfTheDayAction()
    {
        return new JsonResponse(
            'test'
        );
    }
}