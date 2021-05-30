<?php

declare(strict_types=1);

namespace App\Game\Features\GamePlay\Authentication;

use RuntimeException;

final class PlayerNotFoundInTokenStorageException extends RuntimeException
{
}
