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

$nodes = $baremetal->listNodes(['uuid' => '{uuid}']);

foreach ($nodes as $node) {
}
