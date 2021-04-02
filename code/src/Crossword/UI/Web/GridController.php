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
    public function __invoke(
        ConstructorFactory $constructorFactory
    ): Response {
        $constructor = $constructorFactory->create(new Type('normal'));
        $crossword = $constructor->build('en', 5);

        $grid = [];
        for ($x = 0; $x <= 20; $x++) {
            for ($y = 0; $y <= 20; $y++) {
                $grid[$x][$y] = '_';
            }
        }
        /** @var Cell $item */
        foreach ($constructor->grid() as $item) {
            $grid[$item->coordinate()->coordinateX()][$item->coordinate()->coordinateY()] = $item->letter();
        }

       // dump($crossword->jsonSerialize());

        return $this->render(
            'grid.html.twig', [
            'grid' => $grid,
        ]
        );
    }
}
