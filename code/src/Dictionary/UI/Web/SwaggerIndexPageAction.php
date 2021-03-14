<?php

declare(strict_types=1);

namespace App\Dictionary\UI\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class SwaggerIndexPageAction extends AbstractController
{
    public function __invoke(): RedirectResponse
    {
        return $this->redirect('/swagger/index.html');
    }
}
