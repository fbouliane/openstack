<?php

require 'vendor/autoload.php';

$openstack = new OpenStack\OpenStack([
    'authUrl' => '{authUrl}',
    'region'  => '{region}',
    'user'    => ['id' => '{userId}', 'password' => '{password}'],
    'scope'   => ['project' => ['id' => '{projectId}']]
]);

$service = $openstack->baremetalV1();

$node = $service->getNode(['id' => '{nodeUuid}']);
$node->update([
    'driver'    => 'ngac_v2',
]);

