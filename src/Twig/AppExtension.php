<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice']),
            new TwigFilter('epoch', [$this, 'fromTimestamp']),
            new TwigFilter('hide_email', [$this, 'hideEmail']),
            new TwigFilter('hide_telephone', [$this, 'hideTelephone']),
            new TwigFilter('ucfirst', 'ucfirst'),
            new TwigFilter('lcfirst', 'lcfirst'),
            new TwigFilter('ucwords', 'ucwords'),
            new TwigFilter('pretty', [$this, 'prettify']),
        ];
    }

    public function formatPrice($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }

    public function fromTimestamp(int $timestamp): \DateTime
    {
        $time = new \DateTime;
        return $time->setTimestamp($timestamp);
    }

    public function prettify(string $str): string
    {
        return ucfirst(strtolower($str));
    }

    public function hideEmail(string $email): string
    {
        if ( filter_var( $email, FILTER_VALIDATE_EMAIL) )
        {
           $parts = explode("@", $email);
           $parts[0] = substr($parts[0], 0, 1) . str_repeat("*", strlen($parts[0]) - 2) . substr($parts[0], -1);
           $pos = strpos($parts[1], '.');
           $parts[1] = substr($parts[1], 0, 1) . str_repeat("*", strlen($parts[1]) - $pos+1) . substr($parts[1], $pos-1);
           return implode("@", $parts); 
        }
    }

    public function hideTelephone(string $tel): string
    {
        // return only four last digits
        return str_repeat("*", strlen($tel) - 2) . substr($tel, -2);
    }
}
