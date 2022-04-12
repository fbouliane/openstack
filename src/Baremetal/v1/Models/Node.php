<?php

declare(strict_types=1);

namespace OpenStack\Baremetal\v1\Models;

use OpenStack\Common\Resource\Creatable;
use OpenStack\Common\Resource\Deletable;
use OpenStack\Common\Resource\Listable;
use OpenStack\Common\Resource\OperatorResource;
use OpenStack\Common\Resource\Retrievable;

/**
 * @property \OpenStack\Baremetal\v1\Api $api
 */
class Node extends OperatorResource implements Creatable, Listable, Retrievable, Deletable
{
    /** @var string */
    public $uuid;

    /** @var string */
    public $instanceUuid;

    /** @var string */
    public $name;

    /** @var string */
    public $driver;

    /** @var bool */
    public $maintenance;

    /** @var string */
    public $provisionState;

    /** @var string */
    public $powerState;

    /** @var array */
    public $driverInfo;

    /** @var array */
    public $links;

    protected $resourceKey  = 'node';
    protected $resourcesKey = 'nodes';
    protected $markerKey    = 'id';

    protected $aliases = [
        'driver_info'     => 'driverInfo',
        'instance_uuid'   => 'instanceUuid',
        'provision_state' => 'provisionState',
        'power_state'     => 'powerState',
    ];

    /**
     * {@inheritdoc}
     */
    public function retrieve()
    {
        $response = $this->execute($this->api->getNode(), $this->getAttrs(['uuid']));
        $this->populateFromResponse($response);
    }

    /**
     * {@inheritdoc}
     *
     * @param array $userOptions {@see \OpenStack\Baremetal\v1\Api::postNode}
     */
    public function create(array $userOptions): Creatable
    {
        $response = $this->execute($this->api->postNode(), $userOptions);

        return $this->populateFromResponse($response);
    }

    public function update(array $data)
    {
        // retrieve latest state so we can accurately produce a diff
        $this->retrieve();

        // formulate diff
        $patch = [];
        foreach ($data as $path => $value) {
            // todo: not the best way to do it, no validation (see v2/Image.php::update)
            // will not work if the path handle array
            $patch[] = [
                'op'    => 'add',
                'path'  => "/$path",
                'value' => $value,
            ];
        }

        $json  = json_encode($patch, JSON_UNESCAPED_SLASHES);

        // execute patch operation
        $response = $this->execute($this->api->patchNode(), [
            'id'          => $this->uuid,
            'patchDoc'    => $json,
            'contentType' => 'application/json',
        ]);

        $this->populateFromResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        $this->execute($this->api->deleteNode(), $this->getAttrs(['uuid']));
    }
}
