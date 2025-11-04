<?php

namespace Petalbranch\PetalCipher;

use RuntimeException;

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
    public static function applyOffsetToString(string $string, Seed $seed, int $offset = 0): string
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
    public static function hasSameChars(string $compareChars, string $targetChars): bool
    {
        // 比较两个字符串的长度是否相等
        if (strlen($compareChars) !== strlen($targetChars)) return false;

        // 使用count_chars函数统计两个字符串中各字符的出现次数并进行比较
        return count_chars($compareChars, 1) === count_chars($targetChars, 1);
    }


    /**
     * 包含必要的文件
     *
     * 此函数负责加载项目所需的核心文件，确保所有依赖文件都存在并正确引入
     *
     * @throws RuntimeException 当必需的文件不存在时抛出异常
     */
    public static function requireOnceFiles()
    {
        // 定义需要包含的文件列表
        $files = ['Constant.php',
            'Seed.php',
            'Encrypt.php',
            'Decrypt.php',
            'PetalCipher.php',
            'Helper.php'
        ];

        // 设置基础路径
        $basePath = __DIR__ . '/';

        // 遍历文件列表并包含每个文件
        foreach ($files as $file) {
            $filePath = $basePath . $file;
            if (file_exists($filePath)) {
                require_once $filePath;
            } else {
                throw new RuntimeException("Required file not found: " . $filePath);
            }
        }
    }


}