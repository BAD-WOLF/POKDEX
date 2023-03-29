<?php

namespace App\Controller;

use App\Service\ServiceApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListPokemonController extends AbstractController
{
    private ServiceApi $serviceApi;

    #[Route('/list/pokemon', name: 'app_list_pokemon')]
    public function index(ServiceApi $serviceApi): Response
    {
        $this->serviceApi = $serviceApi;

        $date = $this->quantityOfRequests(20);

        //dd($date);

        return $this->render('list_pokemon/index.html.twig', [
            'date' => $date
        ]);
    }

    private function quantityOfRequests(int $quantity): array
    {
        for($i = 1; $i <= $quantity; $i++){
            $date[] = json_decode($this->serviceApi->getData("v1/pokemon/$i"), true);
        }

        return $date;
    }

}

