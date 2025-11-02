<?php

use Petalbranch\PetalCipher\Seed;
use PHPUnit\Framework\TestCase;

class SeedTest extends TestCase
{

    /** @noinspection PhpParamsInspection */
    public function testSeed()
    {
        // SeedInput 为 null 时字典会根据“系统信息和PHP版本”生成，其内容在根据所依赖的信息未发生变更时是保持不变的
        $seed = new Seed();
        $expected = $seed;
        $seed = new Seed(null);
        $this->assertEquals($expected->getSeed(),$seed->getSeed());
        $this->assertEquals($expected->getDictionary(),$seed->getDictionary());
        $this->assertEquals($expected->getToPrivate(),$seed->getToPrivate());
        $this->assertEquals($expected->getToStandard(),$seed->getToStandard());

        // SeedInput 为字符串时，字典会根据字符串生成，其内容在根据所依赖的信息未发生变更时是保持不变的
        $seed = new Seed('123456');
        $expected = $seed;
        $seed = new Seed('123456');
        $this->assertEquals($expected->getSeed(),$seed->getSeed());
        $this->assertEquals($expected->getDictionary(),$seed->getDictionary());
        $this->assertEquals($expected->getToPrivate(),$seed->getToPrivate());
        $this->assertEquals($expected->getToStandard(),$seed->getToStandard());

        // seedInput 为字符串时，字典会根据字符串生成，其内容在根据所依赖的信息发生变更时是字典是不一致的
        $seed = new Seed('123456');
        $expected = $seed;
        $seed = new Seed('1234567');
        $this->assertNotEquals($expected->getSeed(),$seed->getSeed());
        $this->assertNotEquals($expected->getDictionary(),$seed->getDictionary());
        $this->assertNotEquals($expected->getToPrivate(),$seed->getToPrivate());
        $this->assertNotEquals($expected->getToStandard(),$seed->getToStandard());

        // SeedInput 为非字符串时，则抛出异常
        $this->expectException(InvalidArgumentException::class);
        new Seed(123456);
    }


    /** @noinspection PhpParamsInspection */
    public function testUpdateSeed()
    {
        // SeedInput 为 null 时字典会根据“系统信息和PHP版本”生成，其内容在根据所依赖的信息未发生变更时是保持不变的
        $seed = new Seed();
        $expected = clone $seed;
        $seed->updateSeed();
        $this->assertEquals($expected->getSeed(),$seed->getSeed());
        $this->assertEquals($expected->getDictionary(),$seed->getDictionary());
        $this->assertEquals($expected->getToPrivate(),$seed->getToPrivate());
        $this->assertEquals($expected->getToStandard(),$seed->getToStandard());

        // SeedInput 为字符串时，字典会根据字符串生成，其内容在根据所依赖的信息未发生变更时是保持不变的
        $seed = new Seed('123456');
        $expected = clone $seed;
        $seed->updateSeed('123456');
        $this->assertEquals($expected->getSeed(),$seed->getSeed());
        $this->assertEquals($expected->getDictionary(),$seed->getDictionary());
        $this->assertEquals($expected->getToPrivate(),$seed->getToPrivate());
        $this->assertEquals($expected->getToStandard(),$seed->getToStandard());

        // seedInput 为字符串时，字典会根据字符串生成，其内容在根据所依赖的信息发生变更时是字典是不一致的
        $seed = new Seed('123456');
        $expected = clone $seed;
        $seed->updateSeed('1234567');
        $this->assertNotEquals($expected->getSeed(),$seed->getSeed());
        $this->assertNotEquals($expected->getDictionary(),$seed->getDictionary());
        $this->assertNotEquals($expected->getToPrivate(),$seed->getToPrivate());
        $this->assertNotEquals($expected->getToStandard(),$seed->getToStandard());

        // SeedInput 为非字符串时，则抛出异常
        $this->expectException(InvalidArgumentException::class);
        new Seed();
        $seed->updateSeed(123456);
    }

}
