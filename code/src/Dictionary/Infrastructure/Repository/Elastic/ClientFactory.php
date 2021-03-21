<?php

declare(strict_types=1);

namespace App\Dictionary\Infrastructure\Repository\Elastic;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

final class ClientFactory
{
    private array $elasticHosts;

    public function __construct(array $elasticHosts)
    {
        $this->elasticHosts = $elasticHosts;
    }

    public function create(): Client
    {
        return ClientBuilder::create()->setHosts($this->elasticHosts)->build();
    }
}
