<?php

declare(strict_types=1);

namespace OpenStack\Baremetal\v1;

use OpenStack\Baremetal\v1\Models\Node;
use OpenStack\Common\Service\AbstractService;

/**
 * Baremetal v1 service for OpenStack.
 *
 * @property \OpenStack\Baremetal\v1\Api $api
 */
class Service extends AbstractService
{
    /**
     * Create a new node resource.
     *
     * @param array $options {@see \OpenStack\Baremetal\v1\Api::postNode}
     */
    public function createNode(array $options): Node
    {
        return $this->model(Node::class)->create($options);
    }

    /**
     * List nodes.
     *
     * @param array $options {@see \OpenStack\Baremetal\v1\Api::getNodes}
     */
    public function listNodes(array $options = []): \Generator
    {
        return $this->model(Node::class)->enumerate($this->api->getNodes(), $options);
    }

    /**
     * Retrieve a node object without calling the remote API. Any values provided in the array will populate the
     * empty object, allowing you greater control without the expense of network transactions. To call the remote API
     * and have the response populate the object, call {@see Node::retrieve}. For example:.
     *
     * <code>$node = $service->getNode(['uuid' => '{nodeUuid}']);</code>
     *
     * @param array $options An array of attributes that will be set on the {@see Node} object. The array keys need to
     *                       correspond to the class public properties.
     */
    public function getNode(array $options = []): Node
    {
        $node = $this->model(Node::class);
        $node->populateFromArray($options);

        return $node;
    }
}
