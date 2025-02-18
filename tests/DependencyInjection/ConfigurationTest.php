<?php

declare(strict_types=1);

namespace DocusignBundle\Tests\DependencyInjection;

use DocusignBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Processor
     */
    private $processor;

    protected function setUp(): void
    {
        $this->configuration = new Configuration();
        $this->processor = new Processor();
    }

    public function testDefaultConfig(): void
    {
        $treeBuilder = $this->configuration->getConfigTreeBuilder();
        $config = $this->processor->processConfiguration($this->configuration, [
            'docusign' => [
                'accessToken' => 'token',
                'accountId' => 'ID',
                'defaultSignerName' => 'Grégoire Hébert',
                'defaultSignerEmail' => 'gregoire@les-tilleuls.coop',
                'storages' => [],
            ],
        ]);

        $this->assertInstanceOf(ConfigurationInterface::class, $this->configuration);
        $this->assertInstanceOf(TreeBuilder::class, $treeBuilder);
        $this->assertEquals([
            'accessToken' => 'token',
            'accountId' => 'ID',
            'defaultSignerName' => 'Grégoire Hébert',
            'defaultSignerEmail' => 'gregoire@les-tilleuls.coop',
            'apiURI' => 'https://demo.docusign.net/restapi',
            'callbackRouteName' => 'docusign_callback',
            'webHookRouteName' => 'docusign_webhook',
            'storages' => [],
        ], $config);
    }
}
