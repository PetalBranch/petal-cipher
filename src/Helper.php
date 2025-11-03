<?php

use Petalbranch\PetalCipher\Encrypt;
use Petalbranch\PetalCipher\Decrypt;
use Petalbranch\PetalCipher\Seed;


if (!function_exists('petal_seed')) {
    /**
     * 创建种子对象<br>
     * Create seed object
     *
     * @param ?string $seedInput 加密种子输入值，留空时使用默认种子（系统信息和 PHP 版本作为种子），不建议留空。<br>
     *  Encryption seed input value. If left empty, the default seed (system information and PHP version) will be used. Leaving it empty is not recommended.
     * @return Seed 种子对象<br>Seed object
     */
    function petal_seed($seedInput = null)
    {
        return new Seed($seedInput);
    }


    if (!function_exists('petal_encrypt')) {
        /**
         * 加密数据<br>
         * Encrypted data
         *
         * @param string $string 需要加密的原始数据<br>
         * Original data to be encrypted
         * @param ?Seed $seed 加密种子，可选参数，留空使用默认值。<br>
         * Encryption seed, optional parameter. Leave empty to use the default value.
         * @return string 返回解密数据<br>
         * Returns the encrypted data
         */
        function petal_encrypt($string, $seed = null)
        {
            return Encrypt::handle($string, $seed);
        }
    }


    if (!function_exists('petal_decrypt')) {
        /**
         * 解密数据<br>
         * Decrypted data
         *
         * @param string $string 待解密的数据<br>
         * Data to be decrypted
         * @param ?Seed $seed 解密种子，可选参数，留空使用默认值。<br>
         * Decryption seed, optional parameter. Leave empty to use the default value.
         * @return string|false 解密数据; 解密失败返回 false<br>
         * Returns the decrypted data; returns false on failure
         */
        function petal_decrypt($string, $seed = null)
        {
            return Decrypt::handle($string, $seed);
        }
    }

    if (!function_exists('petal_custom_dict')) {

        /**
         * 自定义字典<br>
         * Custom dictionary
         *
         * @param string $dict 自定义字典字符串，必须包含所有标准字符集中的字符。<br>
         * Custom dictionary string. Must include all characters from the standard character set.
         * @return Seed 种子对象<br>
         * Seed object
         */
        function petal_custom_dict($dict)
        {
            $seed = new Seed();
            return $seed->setDictionary($dict);
        }
    }
}
