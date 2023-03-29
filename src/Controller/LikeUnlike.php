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
        $dir = getenv("HOME");
        system("touch " . $dir . "/like " . $dir . "/unlike");

        if ($status == "like") {
            if (filesize($dir . "/like") == 0) {
                $numL = 1;
                file_put_contents($dir . "/like", $numL);
            } else {
                $dateL = intval(file_get_contents($dir . "/like"));
                $dateL++;
                file_put_contents($dir . "/like", $dateL);
            }
        } elseif ($status == "unlike") {
            if (filesize($dir . "/unlike") == 0) {
                $numU = 1;
                file_put_contents($dir . "/unlike", $numU);
            } else {
                $dateU = intval(file_get_contents($dir . "/unlike"));
                $dateU++;
                file_put_contents($dir . "/unlike", $dateU);
            }
        } else {
            throw new \InvalidArgumentException("Invalid status {{$status}}.");
        }

        return $this->json([
            "like" => intval(file_get_contents($dir . "/like")),
            "unlike" => intval(file_get_contents($dir . "/unlike"))
        ]);
    }
}

