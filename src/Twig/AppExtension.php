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
            new TwigFilter('ucfirst', 'ucfirst'),
            new TwigFilter('lcfirst', 'lcfirst'),
            new TwigFilter('ucwords', 'ucwords'),
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
}
