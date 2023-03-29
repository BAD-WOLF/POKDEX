<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LikeUnlike
 * @package App\Controller
 */
class LikeUnlike extends AbstractController
{
    #[Route("/likeunlike/{status}", name: "LikeUnlike")]
    public function index($status)
    {
        if ($status == "like") {
            $this->toggleLike();
        } elseif ($status == "unlike") {
            $this->toggleUnlike();
        } else {
            throw new \InvalidArgumentException("Invalid status {{$status}}.");
        }

        $likes = intval($this->getLikesCount());
        $unlikes = intval($this->getUnlikesCount());

        return $this->json([
            "like" => $likes,
            "unlike" => $unlikes
        ]);
    }

    private function toggleLike()
    {
        $likeCookieName = 'like_cookie';
        $unlikeCookieName = 'unlike_cookie';

        if ($this->isCookieSet($likeCookieName)) {
            $this->removeLike();
            $this->deleteCookie($likeCookieName);
        } elseif ($this->isCookieSet($unlikeCookieName)) {
            $this->removeUnlike();
            $this->addLike();
            $this->deleteCookie($unlikeCookieName);
            $this->setCookie($likeCookieName);
        } else {
            $this->addLike();
            $this->setCookie($likeCookieName);
        }
    }

    private function toggleUnlike()
    {
        $likeCookieName = 'like_cookie';
        $unlikeCookieName = 'unlike_cookie';

        if ($this->isCookieSet($unlikeCookieName)) {
            $this->removeUnlike();
            $this->deleteCookie($unlikeCookieName);
        } elseif ($this->isCookieSet($likeCookieName)) {
            $this->removeLike();
            $this->addUnlike();
            $this->deleteCookie($likeCookieName);
            $this->setCookie($unlikeCookieName);
        } else {
            $this->addUnlike();
            $this->setCookie($unlikeCookieName);
        }
    }

    private function addLike()
    {
        $this->incrementCount('like');
    }

    private function removeLike()
    {
        $this->decrementCount('like');
    }

    private function addUnlike()
    {
        $this->incrementCount('unlike');
    }

    private function removeUnlike()
    {
        $this->decrementCount('unlike');
    }

    private function incrementCount($type)
    {
        $dir = getenv("HOME");
        $countFile = $dir . '/' . $type;

        if (!file_exists($countFile)) {
            touch($countFile);
        }

        if (filesize($countFile) == 0) {
            $count = 1;
        } else {
            $count = intval(file_get_contents($countFile));
            $count++;
        }

        file_put_contents($countFile, $count);
    }

    private function decrementCount($type)
    {
        $dir = getenv("HOME");
        $countFile = $dir . '/' . $type;

        if (!file_exists($countFile)) {
            touch($countFile);
        } 

        if (filesize($countFile) > 0) {
            $count = intval(file_get_contents($countFile));
            $count--;

            if ($count < 0) {
                $count = 0;
            }

            file_put_contents($countFile, $count);
        }
    }

    private function getLikesCount()
    {
        $dir = getenv("HOME");
        $countFile = $dir . '/like';

        return file_exists($countFile) ? file_get_contents($countFile) : 0;
    }

    private function getUnlikesCount()
    {
        $dir = getenv("HOME");
        $countFile = $dir . '/unlike';

        return file_exists($countFile) ? file_get_contents($countFile) : 0;
    }

    private function isCookieSet($cookieName)
    {
        return isset($_COOKIE[$cookieName]);
    }

    private function setCookie($cookieName)
    {
        $cookieValue = '1'; // Set a value to the cookie

        // Set the cookie for 1 year (adjust the expiration time as needed)
        $expiration = time() + (365 * 24 * 60 * 60);

        setcookie($cookieName, $cookieValue, $expiration);
    }

    private function deleteCookie($cookieName)
    {
        unset($_COOKIE[$cookieName]);

        // Set the cookie to expire in the past to delete it
        $expiration = time() - 3600;

        setcookie($cookieName, '', $expiration);
    }
}

