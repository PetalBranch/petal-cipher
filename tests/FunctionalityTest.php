<?php /** @noinspection PhpParamsInspection */

use Petalbranch\PetalCipher\Seed;
use Petalbranch\PetalCipher\PetalCipher;
use PHPUnit\Framework\TestCase;

class FunctionalityTest extends TestCase
{

    public function testFunction()
    {
        include __DIR__ . '/../src/Helper.php';

        // 默认种子1
        $encrypt = petal_encrypt('hello world');
        $this->assertTrue(is_string($encrypt));
        $this->assertNotEquals('hello world', $encrypt);
        $this->assertEquals('hello world', petal_decrypt($encrypt));

        for ($i = 0; $i < 1000; $i++) {
            $encrypt = petal_encrypt((string)$i);
            $this->assertTrue(is_string($encrypt));
            $this->assertNotEquals((string)$i, $encrypt);
            $this->assertEquals((string)$i, petal_decrypt($encrypt));
        }

        // 默认种子2
        $seed = petal_seed();
        $this->assertTrue($seed instanceof Seed);

        $encrypt = petal_encrypt('hello world', $seed);
        $this->assertTrue(is_string($encrypt));
        $this->assertNotEquals('hello world', $encrypt);
        $this->assertEquals('hello world', petal_decrypt($encrypt, $seed));

        for ($i = 0; $i < 1000; $i++) {
            $encrypt = petal_encrypt((string)$i, $seed);
            $this->assertTrue(is_string($encrypt));
            $this->assertNotEquals((string)$i, $encrypt);
            $this->assertEquals((string)$i, petal_decrypt($encrypt, $seed));
        }

        // 自定义种子
        $seed = petal_seed("2025年11月02日");
        $this->assertTrue($seed instanceof Seed);

        $encrypt = petal_encrypt('hello world', $seed);
        $this->assertTrue(is_string($encrypt));
        $this->assertNotEquals('hello world', $encrypt);
        $this->assertEquals('hello world', petal_decrypt($encrypt, $seed));

        for ($i = 0; $i < 1000; $i++) {
            $encrypt = petal_encrypt((string)$i, $seed);
            $this->assertTrue(is_string($encrypt));
            $this->assertNotEquals((string)$i, $encrypt);
            $this->assertEquals((string)$i, petal_decrypt($encrypt, $seed));
        }


    }


    public function testClass()
    {
        // 默认种子
        $pc = new PetalCipher();
        $expected = null;
        $this->assertEquals($expected, $pc->getSeed());

        $encrypt = $pc->encrypt('hello world');
        $this->assertTrue(is_string($encrypt));
        $this->assertNotEquals('hello world', $encrypt);
        $this->assertEquals('hello world', $pc->decrypt($encrypt));


        for ($i = 0; $i < 1000; $i++) {
            $encrypt = $pc->encrypt((string)$i);
            $this->assertTrue(is_string($encrypt));
            $this->assertNotEquals((string)$i, $encrypt);
            $this->assertEquals((string)$i, $pc->decrypt($encrypt));
        }


        // 自定义种子
        $pc = new PetalCipher("2025年11月02日");
        $expected = "2025年11月02日";
        $this->assertEquals($expected, $pc->getSeed());

        $encrypt = $pc->encrypt('hello world');
        $this->assertTrue(is_string($encrypt));
        $this->assertNotEquals('hello world', $encrypt);
        $this->assertEquals('hello world', $pc->decrypt($encrypt));

        for ($i = 0; $i < 1000; $i++) {
            $encrypt = $pc->encrypt((string)$i);
            $this->assertTrue(is_string($encrypt));
            $this->assertNotEquals((string)$i, $encrypt);
            $this->assertEquals((string)$i, $pc->decrypt($encrypt));
        }


        // 更新种子
        $pc->updateSeed('upupup');
        $expected = "upupup";
        $this->assertEquals($expected, $pc->getSeed());

        $encrypt = $pc->encrypt('hello world');
        $this->assertTrue(is_string($encrypt));
        $this->assertNotEquals('hello world', $encrypt);
        $this->assertEquals('hello world', $pc->decrypt($encrypt));

        for ($i = 0; $i < 1000; $i++) {
            $encrypt = $pc->encrypt((string)$i);
            $this->assertTrue(is_string($encrypt));
            $this->assertNotEquals((string)$i, $encrypt);
            $this->assertEquals((string)$i, $pc->decrypt($encrypt));
        }
    }

    public function testZoer()
    {
        $pc = new PetalCipher();
        $encrypt = $pc->encrypt('hello world');
        echo "E1: ".$encrypt."\n";
        $decrypt = $pc->decrypt($encrypt);
        echo "D1: ".$decrypt."\n";
        $encrypt = $pc->encrypt('hello world');
        echo "E2: ".$encrypt."\n";
        $decrypt = $pc->decrypt($encrypt);
        echo "D2: ".$decrypt."\n";
        $this->assertTrue(true);
    }
}
