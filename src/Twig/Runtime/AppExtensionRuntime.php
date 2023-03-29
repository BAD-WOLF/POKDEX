<?php

namespace App\Twig\Runtime;

use GuzzleHttp\Client;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function request(string $value)
    {
        // ...
        $req = new Client();
        $req->request("get", "http:/localhost:1234$value")->getBody()->getContents();
    }
}
