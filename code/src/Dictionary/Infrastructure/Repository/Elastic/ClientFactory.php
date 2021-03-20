<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Repository\Elastic;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

final class ClientFactory
{
    private array $hosts;

    public function __construct(array $hosts)
    {
        $this->hosts = $hosts;
    }

    public function create(): Client
    {
        return ClientBuilder::create()->setHosts($this->hosts)->build();
    }
}
