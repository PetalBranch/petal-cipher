<?php

namespace Petalbranch\PetalCipher;

class Constant
{

    /** @var string 标准字符集
     */
    const STANDARD = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

    /**
     * 偏移字符第三位无效字符列表
     */
    const INVAILD_CHAR_3_LIST = "BCDFGHJKLNOPRSTVWXZabdefhijlmnopqrstuvwxyz0123456789";

    /**
     * 无效字符列表
     */
    const INVAILD_CHARS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

}