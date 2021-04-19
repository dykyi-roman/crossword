<?php

declare(strict_types=1);

namespace App\Game\Application\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class EncodeExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('base64', [$this, 'encode']),
        ];
    }

    public function encode(string $string): string
    {
        return base64_encode($string);
    }
}
