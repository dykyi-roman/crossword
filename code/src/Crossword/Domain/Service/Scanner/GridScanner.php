<?php

declare(strict_types=1);

namespace App\Crossword\Domain\Service\Scanner;

use App\Crossword\Domain\Model\Grid;
use App\Crossword\Domain\Model\Row;

final class GridScanner
{
    private const SCAN_ROW_LENGTH = 5;

    private RowXScanner $rowXScanner;
    private RowYScanner $rowYScanner;

    public function __construct(RowXScanner $rowXScanner, RowYScanner $rowYScanner)
    {
        $this->rowXScanner = $rowXScanner;
        $this->rowYScanner = $rowYScanner;
    }

    /**
     * @return Row[]
     */
    public function scan(Grid $grid): array
    {
        $rows = array_merge(
            $this->rowXScanner->scan($grid, self::SCAN_ROW_LENGTH),
            $this->rowYScanner->scan($grid, self::SCAN_ROW_LENGTH)
        );
        shuffle($rows);

        return $rows;
    }
}
