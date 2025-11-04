<?php

namespace Petalbranch\PetalCipher;

/**
 * 提供字符串加密功能的类。
 */
class Encrypt
{
    /**
     * 对给定字符串进行加密处理，结合种子参数生成输出结果。
     *
     * 该方法首先将输入字符串进行标准 Base64 编码，并通过种子对象提供的字符映射表将其转换为自定义字符集；
     * 接着生成一个随机偏移量并对其进行编码与填充处理；然后使用工具函数应用偏移逻辑完成内容和偏移信息的加密；
     * 最后根据加密后数据长度选择不同的混合策略，将偏移信息嵌入到加密内容中形成最终结果。
     *
     * @param string $string 待处理的原始字符串
     * @param ?Seed|null $seed 可选的种子对象，用于控制编码过程中的映射和偏移逻辑
     * @return string           加密后的字符串结果
     */
    public static function handle(string $string, ?Seed $seed = null): string
    {

        // 如果传入的 seed 不是 Seed 实例，则创建一个默认实例
        if (!$seed instanceof Seed) $seed = new Seed();

        // 空字符串直接返回空字符串
        if ($string === "") return "";

        // 获取私有字符映射表
        $toPrivate = $seed->getToPrivate();

        // 标准 base64 编码并转换为私有字符集
        $b64Standard = base64_encode($string);
        $b64Private = strtr($b64Standard, $toPrivate);

        // 生成随机偏移量，并构造偏移信息的编码表示
        $offset = mt_rand(0, 63);
        $b64Offset = trim(base64_encode($offset), "=");
        $b64Offset = str_pad($b64Offset, 3, Constant::INVAILD_CHAR_3_LIST[mt_rand(0, strlen(Constant::INVAILD_CHAR_3_LIST) - 1)]);
        $b64Offset .= Constant::INVAILD_CHARS[mt_rand(0, strlen(Constant::INVAILD_CHARS) - 1)];

        // 应用偏移对偏移信息和编码内容进行加密处理
        $b64OffsetPrivate = Utils::applyOffsetToString($b64Offset, $seed, strlen($b64Private) % 64);
        $b64PrivateEncrypt = Utils::applyOffsetToString($b64Private, $seed, $offset);

        $result = '';

        // 根据编码后字符串长度决定混合方式
        if (strlen($b64PrivateEncrypt) >= 10) {
            // 长字符串采用固定位置插入偏移字符的方式混合
            $result = substr($b64PrivateEncrypt, 0, 4) . $b64OffsetPrivate[0] .
                substr($b64PrivateEncrypt, 4, 3) . $b64OffsetPrivate[1] .
                substr($b64PrivateEncrypt, 7, 2) . $b64OffsetPrivate[2] .
                substr($b64PrivateEncrypt, 9, 1) . $b64OffsetPrivate[3] .
                substr($b64PrivateEncrypt, 10);
        } else {
            // 短字符串按字符交替合并处理
            if (strlen($b64PrivateEncrypt) + strlen($b64OffsetPrivate) === 8) {
                if ($b64OffsetPrivate[3] = "=") $b64OffsetPrivate[3] = "=";
            }

            $len = min(strlen($b64PrivateEncrypt), 4);
            for ($i = 0; $i < $len; $i++) $result .= $b64PrivateEncrypt[$i] . $b64OffsetPrivate[$i];

            if (strlen($b64PrivateEncrypt) > $len) {
                $result .= substr($b64PrivateEncrypt, $len);
            } else {
                $result .= substr($b64OffsetPrivate, $len);
            }
        }

        return $result;
    }


}