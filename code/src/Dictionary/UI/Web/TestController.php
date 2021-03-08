<?php

declare(strict_types=1);

namespace App\Dictionary\UI\Web;

use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IgnoreAnnotation("OA\Info")
 * @IgnoreAnnotation("OA\SecurityScheme")
 * @IgnoreAnnotation("OA\Get")
 * @IgnoreAnnotation("OA\Response")
 *
 * @OA\Info(title="Dictionary API", version="1.0.0")
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 * )
 */
final class TestController extends AbstractController
{
    /**
     * @OA\Get(
     *     path="/test",
     *     description="Test page",
     *     @OA\Response(response="default", description="test page")
     * )
     *
     * @Route(path="/test", methods={"GET"}, name="web.test")
     */
    public function index(): RedirectResponse
    {
        return $this->redirect('/swagger/index.html');
    }
}
