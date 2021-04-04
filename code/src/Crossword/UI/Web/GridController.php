<?php

declare(strict_types=1);

namespace App\Crossword\UI\Web;

use App\Crossword\Application\Service\ConstructorFactory;
use App\Crossword\Domain\Enum\Type;
use App\Crossword\Domain\Model\Cell;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GridController extends AbstractController
{
    #[Route('/crossword/grid', name: 'web.crossword.grid', methods: ['GET'])]
    public function __invoke(ConstructorFactory $constructorFactory): Response
    {
        $constructor = $constructorFactory->create(new Type('normal'));
        $constructor->build('en', 5);

        $grid = [];
        for ($xCounter = 0; $xCounter <= 20; $xCounter++) {
            for ($yCounter = 0; $yCounter <= 20; $yCounter++) {
                $grid[$xCounter][$yCounter] = '_';
            }
        }
        /** @var Cell $item */
        foreach ($constructor->grid() as $item) {
            $coordinate = $item->coordinate();
            $grid[$coordinate->coordinateX()][$coordinate->coordinateY()] = $item->letter();
        }

        return $this->render(
            'grid.html.twig',
            [
                'grid' => $grid,
            ]
        );
    }
}
