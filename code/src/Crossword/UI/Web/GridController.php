<?php

declare(strict_types=1);

namespace App\Crossword\UI\Web;

use App\Crossword\Application\Service\ConstructorFactory;
use App\Crossword\Domain\Enum\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GridController extends AbstractController
{
    #[Route('/crossword/grid', name: 'web.crossword.grid', methods: ['GET'])]
    public function __invoke(ConstructorFactory $constructorFactory): Response
    {
        $constructor = $constructorFactory->create(new Type('normal'));
        $crossword = $constructor->build('en', 5);

        return $this->render('grid.html.twig', [
            'grid' => $constructor->grid(),
        ]);
    }
}
