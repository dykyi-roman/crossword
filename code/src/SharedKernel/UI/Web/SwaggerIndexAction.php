<?php

declare(strict_types=1);

namespace App\SharedKernel\UI\Web;

use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @IgnoreAnnotation("OA\Info")
 *
 * @OA\Info(title="Crossword API", version="1.0.1")
 */
final class SwaggerIndexAction extends AbstractController
{
    public function __invoke(): RedirectResponse
    {
        return $this->redirect('/swagger/index.html');
    }
}
