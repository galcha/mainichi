<?php

namespace App\Controller;

use App\Helper\WordHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController Extends Controller
{
    /**
     * @Route("/word/", name="app_word")
     */
    public function wordOfTheDayAction(Request $request, WordHelper $wordHelper)
    {
        $offset = $request->query->get('offset', 0);
        return new JsonResponse(
            $wordHelper->getWordOfTheDay($offset)
        );
    }
}
