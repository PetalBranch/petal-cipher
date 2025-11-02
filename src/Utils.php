<?php

namespace Petalbranch\PetalCipher;

class Utils
{
    /**
     * 对字符串应用偏移量进行字符替换
     *
     * 该函数通过种子对象提供的字符映射表，对输入字符串中的每个字符进行偏移替换，
     * 相同字符会被映射到映射表中偏移指定位置的字符，等号字符保持不变
     *
     * @param string $string 需要处理的输入字符串
     * @param Seed $seed 种子对象
     * @param int $offset 偏移量，用于计算字符在映射表中的新位置，默认为0
     * @return string 处理后的字符串，其中字符根据偏移量进行了替换
     */
    public static function applyOffsetToString($string, $seed, $offset = 0)
    {
        $toPrivate = $seed->getDictionary();

        $result = '';

        // 遍历字符串中的每个字符，根据偏移量进行字符替换
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];

            // 等号字符不进行替换，直接保留
            if ($char == "=") {
                $result .= $char;
                continue;
            }

            // 查找当前字符在映射表中的位置，并根据偏移量计算新位置
            $pos = strpos($toPrivate, $char);
            $result .= $toPrivate[($pos + $offset) % strlen($toPrivate)];
        }
        return $result;
    }


}