<?php

declare(strict_types=1);

namespace OpenStack\Baremetal\v1;

use OpenStack\Common\Api\AbstractParams;

class Params extends AbstractParams
{
    public function urlUuid(string $type): array
    {
        return array_merge(parent::id($type), [
            'required'   => true,
            'location'   => self::URL,
            'documented' => false,
        ]);
    }

    public function driverInfo(string $type): array
    {
        return [
            'type'        => self::ARRAY_TYPE,
            'sentAs'      => 'block_device_mapping_v2',
            'description' => <<<EOL
Enables booting the server from a volume when additional parameters are given. If specified, the volume status must be
available, and the volume attach_status in OpenStack Block Storage DB must be detached.
EOL
            ,
            'items' => [
                'type'       => self::OBJECT_TYPE,
                'properties' => [
                    'uuid' => [
                        'type'        => self::STRING_TYPE,
                        'description' => 'The unique ID for the volume which the server is to be booted from.',
                    ],
                    'bootIndex' => [
                        'type'        => self::INT_TYPE,
                        'sentAs'      => 'boot_index',
                        'description' => 'Indicates a number designating the boot order of the device. Use -1 for the boot volume, choose 0 for an attached volume.',
                    ],
                    'deleteOnTermination' => [
                        'type'        => self::BOOL_TYPE,
                        'sentAs'      => 'delete_on_termination',
                        'description' => 'To delete the boot volume when the server stops, specify true. Otherwise, specify false.',
                    ],
                    'guestFormat' => [
                        'type'        => self::STRING_TYPE,
                        'sentAs'      => 'guest_format',
                        'description' => 'Specifies the guest server disk file system format, such as "ephemeral" or "swap".',
                    ],
                    'destinationType' => [
                        'type'        => self::STRING_TYPE,
                        'sentAs'      => 'destination_type',
                        'description' => 'Describes where the volume comes from. Choices are "local" or "volume". When using "volume" the volume ID',
                    ],
                    'sourceType' => [
                        'type'        => self::STRING_TYPE,
                        'sentAs'      => 'source_type',
                        'description' => 'Describes the volume source type for the volume. Choices are "blank", "snapshot", "volume", or "image".',
                    ],
                    'deviceName' => [
                        'type'        => self::STRING_TYPE,
                        'sentAs'      => 'device_name',
                        'description' => 'Describes a path to the device for the volume you want to use to boot the server.',
                    ],
                    'volumeSize' => [
                        'type'        => self::INT_TYPE,
                        'sentAs'      => 'volume_size',
                        'description' => 'Size of the volume created if we are doing vol creation',
                    ],
                ],
            ],
        ];
    }
}
