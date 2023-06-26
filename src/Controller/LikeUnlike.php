<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LikeUnlike
 * @package App\Controller
 */
class LikeUnlike extends AbstractController
{
    #[Route("/likeunlike/{status}", name: "LikeUnlike")]
    public function index($status)
    {

        #$dir = getenv("HOME"); // Retornou vazio e com status 500 (Permissão negada)
        $dir = 'C:\Users\silas'; // Funciona /like e /unlike porque ta fixo o diretório

        $likeFile = $dir . "/like";
        $unlikeFile = $dir . "/unlike";

        /*
        var_dump($likeFile);
        exit;
        */

        // Cria o arquivo "like" se não existir
        if (!file_exists($likeFile)) {
            touch($likeFile);
        }

        // Cria o arquivo "unlike" se não existir
        if (!file_exists($unlikeFile)) {
            touch($unlikeFile);
        }

        if ($status == "like") {
            if (filesize($likeFile) == 0) {
                $numL = 1;
                file_put_contents($likeFile, $numL);
            } else {
                $dateL = intval(file_get_contents($likeFile));
                $dateL++;
                file_put_contents($likeFile, $dateL);
            }
        } elseif ($status == "unlike") {
            if (filesize($unlikeFile) == 0) {
                $numU = 1;
                file_put_contents($unlikeFile, $numU);
            } else {
                $dateU = intval(file_get_contents($unlikeFile));
                $dateU++;
                file_put_contents($unlikeFile, $dateU);
            }
        } else {
            throw new \InvalidArgumentException("Invalid status {{$status}}.");
        }

        return $this->json([
            "like" => intval(file_get_contents($likeFile)),
            "unlike" => intval(file_get_contents($unlikeFile))
        ]);
    }
}
