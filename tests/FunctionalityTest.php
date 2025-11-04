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
        // 这里随便写的，不做测试用途
//        $pc = new PetalCipher();
//        $encrypt = $pc->encrypt('hello world');
//        echo "E1: ".$encrypt."\n";
//        $decrypt = $pc->decrypt($encrypt);
//        echo "D1: ".$decrypt."\n";
//        $encrypt = $pc->encrypt('hello world');
//        echo "E2: ".$encrypt."\n";
//        $decrypt = $pc->decrypt($encrypt);
//        echo "D2: ".$decrypt."\n";


        $seed = petal_seed("123456");

        $string = "hello, world.";
        $encrypt = petal_encrypt($string, $seed);
        $decypt = petal_decrypt($encrypt, $seed);

        echo "PV: " . phpversion() . "\n";
        echo "O:  " . $string . "\n";
        echo "E:  " . $encrypt . "\n";
        echo "D:  " . $decypt . "\n";
        echo "\n---------\n PV7";


        echo petal_decrypt("Ye0HcyePXHa/nj+B49x3cU==", $seed) . "\n";
        echo petal_decrypt("02bKcp2NXKuZ6KtdsrHjey==", $seed) . "\n";
        echo petal_decrypt("x+Huch+G5ujzX2Sew8a1lN==", $seed) . "\n";
        echo petal_decrypt("4as/c+a7X/DPCljxXgw9zl==", $seed) . "\n";
        echo petal_decrypt("DAo4JcAHr4FDN4zjfprL1b==", $seed) . "\n";
        echo petal_decrypt("ZEXTc3EoCTmSbH9FQBiOLv==", $seed) . "\n";
        echo petal_decrypt("WiCUJEiMrUP51hmZbYQtkL==", $seed) . "\n";
        echo petal_decrypt("x+Huch+G5ujCXISew8a1lN==", $seed) . "\n";
        echo petal_decrypt("PgNWJ8gXCWd/vLkm7aGeO6==", $seed) . "\n";
        echo petal_decrypt("suIvctu5XvoJJkYHqZ/ra+==", $seed) . "\n";
        echo petal_decrypt("HtK7JOtWD7YlqLB2/FuA+h==", $seed) . "\n";
        echo petal_decrypt("AlxaJNltCa3DZf5cF6zVKP==", $seed) . "\n";





        // 结束
        $this->assertTrue(true);
    }
}
