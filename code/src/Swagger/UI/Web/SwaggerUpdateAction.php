<?php

declare(strict_types=1);

namespace App\Swagger\UI\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function OpenApi\scan;

class SwaggerUpdateAction extends AbstractController
{
    #[Route('/swagger/update', name: 'web.swagger.update')]
    public function __invoke(ParameterBagInterface $parameterBag): Response
    {
        echo scan($parameterBag->get('DICTIONARY_WEB_DIR'))->toYaml();

        return new Response();
    }
}
