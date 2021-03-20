<?php

declare(strict_types=1);

namespace App\SharedKernel\UI\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;

use function OpenApi\scan;

class SwaggerUpdateAction extends AbstractController
{
    public function __invoke(ParameterBagInterface $parameterBag): Response
    {
        echo scan($parameterBag->get('DICTIONARY_WEB_DIR'))->toYaml();

        return new Response();
    }
}
