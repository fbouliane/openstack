<?php

declare(strict_types=1);

namespace OpenStack\Baremetal\v1;

use OpenStack\Common\Api\AbstractApi;

/**
 * A representation of the Baremetal (Ironic) v1 REST API.
 *
 * @internal
 */
class Api extends AbstractApi
{
    private $pathPrefix = 'v1';

    public function __construct()
    {
        $this->params = new Params();
    }

    public function getNodes(): array
    {
        return [
            'method'  => 'GET',
            'path'    => $this->pathPrefix.'/nodes',
            'params'  => [],
        ];
    }

    public function getNode(): array
    {
        return [
            'method' => 'GET',
            'path'   => $this->pathPrefix.'/nodes/{uuid}',
            'params' => [
                'uuid' => $this->params->urlUuid('node'),
            ],
        ];
    }

    public function postNode(): array // TODO: complete + tests
    {
        return [
            'path'    => 'nodes',
            'method'  => 'POST',
            'jsonKey' => 'node',
            'params'  => [
                'driver' => $this->isRequired($this->params->name('driver')),
                'name'   => $this->isRequired($this->params->name('name')),
                'uuid'   => $this->notRequired($this->params->name('uuid')),
            ],
        ];
    }

    public function deleteNode(): array
    {
        return [
            'method' => 'DELETE',
            'path'   => $this->pathPrefix.'/nodes/{uuid}',
            'params' => ['uuid' => $this->params->urlUuid('node')],
        ];
    }
}
