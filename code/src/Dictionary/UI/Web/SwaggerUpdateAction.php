<?php

declare(strict_types=1);

namespace App\Dictionary\UI\Web;

use function OpenApi\scan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;

class SwaggerUpdateAction extends AbstractController
{
    public function __invoke(ParameterBagInterface $bag): Response
    {
        echo scan($bag->get('DICTIONARY_WEB_DIR'))->toYaml();

        return new Response();
    }
}
