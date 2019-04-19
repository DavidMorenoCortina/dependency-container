<?php

namespace Functional;


use DavidMorenoCortina\DependencyContainer\Container;
use PHPUnit\Framework\TestCase;

class Counter{
    private $i = 0;

    public function __construct(int $initialValue) {
        $this->i = $initialValue;
    }

    public function getNum() {
        return $this->i;
    }

    public function increment() {
        $this->i++;
    }
}

class ContainerTest extends TestCase {
    public function testSettingsDependency() {
        $container = new Container([
            'db' => [
                'host' => 'localhost',
                'port' => 3306
            ]
        ]);

        $settings = $container['settings'];
        $this->assertIsArray($settings);
        $this->assertArrayHasKey('db', $settings);
        $this->assertArrayHasKey('host', $settings['db']);
        $this->assertEquals('localhost', $settings['db']['host']);
    }

    public function testCustomDependency() {
        $container = new Container(['initCounter' => 35]);

        $container['counter'] = function (Container $container){
            return new Counter($container['settings']['initCounter']);
        };

        /** @var Counter $counter */
        $counter = $container['counter'];

        $this->assertEquals(35, $counter->getNum());

        /** @var Counter $otherCounter */
        $otherCounter = $container['counter'];

        $this->assertEquals(35, $otherCounter->getNum());

        $counter->increment();

        $this->assertEquals(36, $otherCounter->getNum());

        $this->assertEquals($counter, $otherCounter);
    }
}