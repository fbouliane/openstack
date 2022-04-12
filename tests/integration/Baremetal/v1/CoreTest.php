<?php

namespace OpenStack\Integration\Baremetal\v1;

use OpenStack\Baremetal\v1\Models\Node;
use OpenStack\Baremetal\v1\Service as BaremetalService;
use OpenStack\Integration\TestCase;
use OpenStack\Integration\Utils;

class CoreTest extends TestCase
{
    // Test environment constants
    const NODE = 'phptest_node';

    private $baremetalService;

    /** @var Node */
    private $node;

    // Core test
    /** @var BaremetalService */
    private $service;
    /** @var string */
    private $nodeUuid;

    private function getService()
    {
        if (null === $this->service) {
            $this->service = Utils::getOpenStack()->baremetalV1();
        }

        return $this->service;
    }

    protected function setUp()
    {
    }

    public function runTests()
    {
        $this->startTimer();

        // Manually trigger setUp
        $this->setUp();

        // Servers
        $this->createNode();

        try {
            $this->retrieveNode();
            $this->patchNode();
        } finally {
            // Teardown
            $this->deleteNode();
        }

        $this->outputTimeTaken();
    }

    private function createNode() // TODO: complete
    {
        $replacements = [
            '{name}'   => $this->randomStr(),
            '{driver}' => 'ipmi',
            '{uuid}'   => $this->randomStr(32),
        ];

        /** @var $node Node */
        $path = $this->sampleFile($replacements, 'servers/create_node.php');
        require_once $path;

        $this->assertInstanceOf(Node::class, $node);
        $this->assertNotEmpty($node->uuid);
        $this->assertNotEmpty($node->name);
        $this->assertNotEmpty($node->driver);

        $this->nodeUuid = $node->uuid;

        $this->logStep('Created node {id}', ['{id}' => $node->uuid]);
    }

    private function retrieveNode()
    {
        $replacements = ['{uuid}' => $this->nodeUuid];

        /** @var $node Node */
        $path = $this->sampleFile($replacements, 'servers/get_node.php');
        require_once $path;

        $this->assertInstanceOf(Node::class, $node);
        $this->assertEquals($this->nodeUuid, $node->uuid);
        $this->assertNotNull($node->name);
        $this->assertNotNull($node->driver);

        $this->logStep('Retrieved the details of node UUID', ['UUID' => $this->nodeUuid]);
    }

    private function deleteNode()
    {
        $replacements = ['{uuid}' => $this->nodeUuid];

        /** @var $node Node */
        $path = $this->sampleFile($replacements, 'servers/delete_node.php');
        require_once $path;

        $this->logStep('Deleted Node UUID', ['UUID' => $this->nodeUuid]);
    }

    private function patchNode()
    {
        $replacements = ['{uuid}' => $this->nodeUuid];

        /** @var $node Node */
        $path = $this->sampleFile($replacements, 'nodes/update_node.php');
        require_once $path;

        $this->logStep('Updated Node UUID', ['UUID' => $this->nodeUuid]);
    }
}
