<?php

declare(strict_types=1);

namespace App\Dictionary\UI\Web;

use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use function OpenApi\scan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    /**
     * @Route(path="/", methods={"GET"}, name="web.swagger.index")
     */
    public function index(): RedirectResponse
    {
        return $this->redirect('/swagger/index.html');
    }

    /**
     * @Route(path="/swagger/update", methods={"GET"}, name="web.swagger.update")
     */
    public function update(ParameterBagInterface $bag): Response
    {
        echo scan($bag->get('DICTIONARY_WEB_DIR'))->toYaml();

        return new Response();
    }
}
