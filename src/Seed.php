<?php

namespace Petalbranch\PetalCipher;

use InvalidArgumentException;

/**
 * Seed 类用于根据给定的种子生成字符映射字典，支持标准字符与自定义字符之间的双向映射。
 */
class Seed
{

    /** @var string $seedInput 种子字符串 */
    private $seedInput;

    /** @var string $dictionary 字符字典 */
    private $dictionary;

    /** @var array $toPrivate 标准字符到自定义字符的映射关系 */
    private $toPrivate = array();

    /** @var array $toStandard 自定义字符到标准字符的映射关系 */
    private $toStandard = array();

    /** @var bool $isCustomDictionary 是否为自定义字典 */
    private $isCustomDictionary = false;

    /**
     * 构造函数，初始化 Seed 实例并生成字符映射字典
     *
     * @param string|null $seedInput 用于生成字典的种子输入，如果为 null 则使用系统信息和 PHP 版本作为种子
     * @throws InvalidArgumentException 如果输入参数不是字符串类型，则抛出异常
     */
    public function __construct($seedInput = null)
    {
        $this->generateDictionary($seedInput);
    }


    /**
     * 生成字符映射字典
     *
     * 该函数根据提供的种子输入生成一个字符映射字典，用于字符转换。
     * 它会创建两个映射表：标准字符到私有字符的映射和私有字符到标准字符的映射。
     *
     * @param string|null $seedInput 用于生成字典的种子输入，如果为null则使用系统信息和PHP版本作为种子
     * @return void
     * @throws InvalidArgumentException 如果输入参数不是字符串类型，则抛出异常
     */
    private function generateDictionary($seedInput)
    {

        $this->seedInput = $seedInput;

        // 根据输入参数确定种子值，如果输入为null则使用系统信息和PHP版本作为种子
        $seed = $this->seedInput === null ? php_uname() . PHP_VERSION : $this->seedInput;

        if (!is_string($seed)) {
            throw new InvalidArgumentException('generateDictionary(): Argument #1 ($seedInput) must be of type string, ' . gettype($seed) . ' given');
        }

        // 使用CRC32算法处理种子，并确保结果为32位无符号整数
        $crc32Result = crc32($seed);
        $seed = $crc32Result & 0xFFFFFFFF;

        // 使用确定的种子初始化随机数生成器，生成字符字典
        mt_srand($seed);
        $this->dictionary = str_shuffle(Constant::STANDARD);

        // 重新初始化随机数生成器，使用默认种子
        mt_srand();

        // 创建标准字符集和字典字符集之间的映射关系
        $standardChars = str_split(Constant::STANDARD);
        $dictionaryChars = str_split($this->dictionary);

        // 建立双向映射表：标准字符到私有字符，以及私有字符到标准字符
        $this->toPrivate = array_combine($standardChars, $dictionaryChars);
        $this->toStandard = array_flip($this->toPrivate);
    }

    /**
     * 设置自定义字典
     *
     * 该函数用于设置自定义的字符映射字典，确保字典包含所有必需的字符，
     * 并建立标准字符集与自定义字典之间的双向映射关系。
     *
     * @param string $dictionary 自定义字典字符串，必须包含所有标准字符集中的字符
     *
     * @return self 返回当前对象实例，支持链式调用
     * @throws InvalidArgumentException 当字典不包含所有必需字符时抛出异常
     */
    public function setDictionary($dictionary)
    {
        if (!Utils::hasSameChars($dictionary, Constant::STANDARD)) {
            throw new InvalidArgumentException('Dictionary characters must match the standard character set.');
        }

        foreach (str_split(Constant::STANDARD) as $char) {
            if (strpos($dictionary, $char) === false) {
                throw new InvalidArgumentException("Dictionary must contain all required characters: a-z, A-Z, 0-9, +, /");
            }
        }

        $this->seedInput = null;
        $this->isCustomDictionary = true;
        $this->dictionary = $dictionary;

        // 创建标准字符集和字典字符集之间的映射关系
        $standardChars = str_split(Constant::STANDARD);
        $dictionaryChars = str_split($this->dictionary);

        // 建立双向映射表：标准字符到私有字符，以及私有字符到标准字符
        $this->toPrivate = array_combine($standardChars, $dictionaryChars);
        $this->toStandard = array_flip($this->toPrivate);

        return $this;
    }


    /**
     * 获取种子输入值
     *
     * @return ?string 返回种子输入值
     */
    public function getSeed()
    {
        return $this->seedInput;
    }

    /**
     * 获取字典数据
     *
     * @return string 返回字典数据
     */
    public function getDictionary()
    {
        return $this->dictionary;
    }


    /**
     * 获取标准字符到自定义字符的映射关系
     *
     * @return array 返回标准字符到自定义字符的映射关系
     */
    public function getToPrivate()
    {
        return $this->toPrivate;
    }


    /**
     * 获取自定义字符到标准字符的映射关系
     *
     * @return array 获取自定义字符到标准字符的映射关系
     */
    public function getToStandard()
    {
        return $this->toStandard;
    }


    /**
     * 更新种子并重新生成字典
     *
     * @param mixed $seedInput 种子输入数据，用于重新生成字典
     * @return self 返回当前对象实例，支持链式调用
     */
    public function updateSeed($seedInput = null)
    {
        // 根据新的种子输入重新生成字典
        $this->generateDictionary($seedInput);
        $this->isCustomDictionary = false;
        return $this;
    }

    /**
     * 将对象转换为字符串表示形式
     *
     * @return string 返回字典属性的字符串值
     */
    public function __toString()
    {
        return $this->dictionary;
    }

    /**
     * 获取是否为自定义字典的标识
     *
     * @return bool 返回是否为自定义字典的布尔值
     */
    public function getIsCustomDictionary()
    {
        return $this->isCustomDictionary;
    }


}