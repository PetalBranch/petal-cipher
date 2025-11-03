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


    /**
     * 比较两个字符串是否包含相同的字符及其出现次数
     *
     * @param string $compareChars 待比较的第一个字符串
     * @param string $targetChars 待比较的第二个字符串
     * @return bool 如果两个字符串包含完全相同的字符且各字符出现次数相同则返回true，否则返回false
     */
    public static function hasSameChars($compareChars, $targetChars)
    {
        // 验证输入参数是否为字符串类型
        if (!is_string($compareChars) || !is_string($targetChars)) return false;

        // 比较两个字符串的长度是否相等
        if (strlen($compareChars) !== strlen($targetChars)) return false;

        // 使用count_chars函数统计两个字符串中各字符的出现次数并进行比较
        return count_chars($compareChars, 1) === count_chars($targetChars, 1);

    }

}