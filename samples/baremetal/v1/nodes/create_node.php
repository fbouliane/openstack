<?php

require 'vendor/autoload.php';

$openstack = new OpenStack\OpenStack([
    'authUrl' => '{authUrl}',
    'region'  => '{region}',
    'user'    => [
        'id'       => '{userId}',
        'password' => '{password}',
    ],
    'scope'   => ['project' => ['id' => '{projectId}']],
]);

$baremetal = $openstack->baremetalV1(['region' => '{region}']);

$options = [ //TODO: add options
    // Required
    'driver' => '{driver}',

    // Optional
    'name'   => '{name}',
    'uuid'   => '{uuid}',
];

// Create the server
/** @var OpenStack\Baremetal\v1\Models\Node $node */
$node = $baremetal->createNode($options);
