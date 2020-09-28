<?php


namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UniqueIdExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('uniqueId', [$this, 'getUniqueId']),
        ];
    }

    public function getName()
    {
        return 'uniqueId';
    }

    public function getUniqueId(int $length = 20)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[mt_rand(0, 61)];
        }

        return $result;
    }
}
