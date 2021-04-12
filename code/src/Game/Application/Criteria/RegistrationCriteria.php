<?php

declare(strict_types=1);

namespace App\Game\Application\Criteria;

use App\Game\Domain\Enum\Role;

/**
 * @psalm-immutable
 *
 * @see RegistrationCommand
 */
final class RegistrationCriteria
{
    private Role $role;
    private string $nickname;
    private string $password;

    public function __construct(string $nickname, string $password, string $role)
    {
        $this->nickname = $nickname;
        $this->password = $password;
        $this->role = new Role($role);
    }

    public function role(): Role
    {
        return $this->role;
    }

    public function nickname(): string
    {
        return $this->nickname;
    }

    public function password(): string
    {
        return $this->password;
    }
}
