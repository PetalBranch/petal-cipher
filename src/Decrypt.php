<?php

namespace Petalbranch\PetalCipher;

class Decrypt
{
    /**
     * 处理加密字符串，对其进行解密并返回原始数据
     *
     * 该函数接收一个加密字符串和可选的Seed实例，通过特定的字符串拆分、偏移处理和Base64解码操作，
     * 尝试还原出原始数据。如果输入字符串长度不足8位，则直接返回false。
     *
     * @param string $string 待处理的加密字符串
     * @param Seed|null $seed 可选的Seed实例，用于控制解密过程中的字符映射和偏移计算
     * @return string|false 解密后的原始数据，如果解密失败或输入无效则返回false
     */
    public static function handle($string, $seed = null)
    {
        // 如果传入的 seed 不是 Seed 实例，则创建一个默认实例
        if (!$seed instanceof Seed) $seed = new Seed();

        // 空字符串或长度小于8的字符串直接返回false
        if ($string === "" || strlen($string) < 8) return false;

        // 根据字符串长度不同，按不同规则提取加密部分和偏移部分
        if (strlen($string) >= 14) {
            $b64PrivateEncrypt = substr($string, 0, 4) .
                substr($string, 5, 3) .
                substr($string, 9, 2) .
                substr($string, 12, 1) .
                substr($string, 14);
            $b64OffsetPrivate = substr($string, 4, 1) .
                substr($string, 8, 1) .
                substr($string, 11, 1);
        } else {
            $b64PrivateEncrypt = substr($string, 0, 1) .
                substr($string, 2, 1) .
                substr($string, 4, 1) .
                substr($string, 6, 1) .
                substr($string, 8);
            $b64OffsetPrivate = substr($string, 1, 1) .
                substr($string, 3, 1) .
                substr($string, 5, 1);
        }

        // 对偏移部分进行反向偏移处理，并转换为标准Base64字符集后补全填充
        $b64Offset = Utils::applyOffsetToString($b64OffsetPrivate, $seed, (strlen($b64PrivateEncrypt) % 64) * -1);
        if (strpos(Constant::INVAILD_CHAR_3_LIST, $b64Offset[3]) !== -1) $b64Offset[3] = "=";
        $b64Offset = str_pad($b64Offset, 4, "=");

        // 解码偏移值，用于后续对加密内容的反向处理
        $offset = (int)base64_decode($b64Offset);

        // 使用解码出的偏移值对加密内容进行反向偏移处理，并转换为标准Base64字符集后解码
        $b64Private = Utils::applyOffsetToString($b64PrivateEncrypt, $seed, $offset * -1);
        $b64Standard = strtr($b64Private, $seed->getToStandard());

        return base64_decode($b64Standard);
    }

}