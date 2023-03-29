<?php
#namespace Services\ConstumTwigExtesion;
namespace App\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
* Class ConstumTwigExtecson
* @author Matheu
*/
class CustomTwigExtesion extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction("print_r", function(array|object $object){
                return "<pre>";print_r($object);echo "</pre>";
            }),
            new TwigFunction("count", function(mixed $mixed){
                return count($mixed);
            }),
            new TwigFunction("hasPosition", function(int|string $key, array $array){
                return array_key_exists($key, $array);
            })
        ];
    }
}

?>
