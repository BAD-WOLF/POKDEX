<?php
#namespace Src\ServiceApi;
namespace App\Service;

use GuzzleHttp\Client;

/**
* Class ServiceApi
* @author Matheu
*/
class ServiceApi
{
    private Client $Client;
    private string $URLbase;

    public function __construct(string $URLbase)
    {
        $this->Client = new Client();
        $this->URLbase = $URLbase;
    }

    public function getData(string $endPoint): string
    {
        $resulte = $this->Client->request("get", $this->URLbase."/".$endPoint);
        return $resulte->getBody()->getContents();
    }
}

?>
