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

$node = $baremetal->getNode(['uuid' => '{uuid}']);

// By default, this will return an empty Server object and NOT hit the API.
// This is convenient for when you want to use the object for operations
// that do not require an initial GET request. To retrieve the server's details,
// run the following, which *will* call the API with a GET request:

$node->retrieve();
