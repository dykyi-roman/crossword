<?php

declare(strict_types=1);

namespace App\Swagger;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;

use function OpenApi\scan;

class SwaggerUpdateAction extends AbstractController
{
    public function __invoke(ParameterBagInterface $parameterBag): Response
    {
        echo scan($parameterBag->get('SCAN_DIR'))->toYaml();

        return new Response();
    }
}
