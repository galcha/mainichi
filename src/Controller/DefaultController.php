<?php

namespace App\Controller;

use App\Helper\WordHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController Extends Controller
{
    /**
     * @Route("/word/", name="app_word")
     */
    public function wordOfTheDayAction(WordHelper $wordHelper)
    {

        $wordHelper->getWordOfTheDay();

        return new JsonResponse(
            $wordHelper->getWordOfTheDay()
        );
    }
}