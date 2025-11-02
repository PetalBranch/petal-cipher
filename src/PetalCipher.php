<?php

namespace Petalbranch\PetalCipher;

use InvalidArgumentException;

/**
 * PetalCipher类
 * 提供加密和解密功能的主类
 */
class PetalCipher
{
    private $seed;

    /**
     * PetalCipher构造函数<br>
     * PetalCipher Construct function
     *
     * 初始化PetalCipher实例，设置加密种子<br>
     * Initialize a PetalCipher instance and set the encryption seed
     *
     * @param string $seedInput 加密种子输入值，留空时使用默认种子（系统信息和 PHP 版本作为种子），不建议留空。<br>
     * Encryption seed input value. If left empty, the default seed (system information and PHP version) will be used. Leaving it empty is not recommended.
     * @throws InvalidArgumentException 如果输入参数不是字符串类型，则抛出异常<br>
     * If the input parameter is not of type string, an exception will be thrown.
     */
    public function __construct($seedInput = null)
    {
        $this->seed = new Seed($seedInput);
    }

    /**
     * 加密函数<br>
     * Encryption function
     *
     * 使用当前种子对输入数据进行加密。<br>
     * Encrypts the input data using the current seed
     *
     * @param string $string 需要加密的原始数据<br>
     * Original data to be encrypted
     * @return string 加密后的数据<br>
     * Encrypted data
     */
    public function encrypt($string)
    {
        return Encrypt::handle($string, $this->seed);
    }

    /**
     * 解密函数<br>
     * Decryption function
     *
     * 使用当前种子对加密数据进行解密。<br>
     * Decrypts the encrypted data using the current seed
     *
     * @param string $string 需要解密的加密数据<br>
     * Encrypted data to be decrypted
     * @return string 解密后的原始数据<br>
     * Decrypted original data
     */
    public function decrypt($string)
    {
        return Decrypt::handle($string, $this->seed);
    }

    /**
     * 获取种子函数<br>
     * Get seed function
     *
     * 返回当前使用的加密种子<br>
     * Returns the currently used encryption seed
     *
     * @return string 当前加密种子值<br>
     * Current encryption seed value
     */
    public function getSeed()
    {
        return $this->seed->getSeed();
    }

    /**
     * 更新种子函数<br>
     * Update seed function
     *
     * 更新当前使用的加密种子<br>
     * Update the currently used encryption seed
     *
     * @param string $seedInput 新的加密种子输入值，留空时使用默认种子（系统信息和 PHP 版本作为种子），不建议留空。<br>
     * New encryption seed input value, If left empty, the default seed (system information and PHP version) will be used. Leaving it empty is not recommended.
     * @return void
     */
    public function updateSeed($seedInput)
    {
        $this->seed->updateSeed($seedInput);
    }

}
