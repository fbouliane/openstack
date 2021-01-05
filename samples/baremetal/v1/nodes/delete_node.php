<?php

require 'vendor/autoload.php';

$openstack = new OpenStack\OpenStack([
    'authUrl' => '{authUrl}',
    'region'  => '{region}',
    'user'    => [
        'id'       => '{userId}',
        'password' => '{password}'
    ],
    'scope'   => ['project' => ['id' => '{projectId}']]
]);

$baremetal = $openstack->baremetalV1(['region' => '{region}']);

/** @var OpenStack\Baremetal\v1\Models\Node $node */
$node = $baremetal->getNode(['uuid' => '{uuid}']);

$node->delete();
