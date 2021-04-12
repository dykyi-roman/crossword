<?php

declare(strict_types=1);

namespace App\Game\Domain\Dto;

use App\Game\Domain\Enum\Level;
use App\Game\Domain\Enum\Role;

final class PlayerRegistrationDto extends PlayerLoginDto
{
    private string $password;

    public function __construct(string $nickname, string $password, Level $level, Role $role)
    {
        parent::__construct($nickname, $level, $role);
        $this->password = $password;
    }

    public function password(): string
    {
        return $this->password;
    }
}
