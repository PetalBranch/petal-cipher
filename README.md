# Petal Cipher

**语言：** <u>👉 简体中文</u> | [English](README_EN.md)

## 简介

**PetalBranch/petal-cipher** 是一个基于转换规则的轻量级可逆的加密库。

## 安装

> PHP 版本要求：>= 5.0 <br>
> ⚠ 开发环境：PHP 8.3 , 低于此版本请先自行测试。

- **使用 Composer 安装**（推荐）
  ```bash
  composer require petalbranch/petal-cipher
  ```
- **手动下载**

  从 GitHub 仓库下载最新版本 ZIP 文件：<br>
  https://github.com/PetalBranch/petal-cipher <br>
  将所有内容解压到项目目录，例如 `vendor/PetalBranch/petal-cipher` <br>
  在 PHP 文件中引入自动加载文件或手动 require：
  ```php
  // 加载助手函数
  require_once 'vendor/PetalBranch/petal-cipher/src/Helpers.php';
  // 加载类文件
  require_once 'vendor/PetalBranch/petal-cipher/src/PetalCipher.php';
  ``` 

## 如何使用

-  使用类文件
    ```php
    <?php
    use Petalbranch\PetalCipher\PetalCipher; // 引入 PetalCipher 类
    
    $pc = new PetalCipher('your_seed'); // 创建 PetalCipher 实例并传入种子
    
    $encrypted = $pc->encrypt('your_data'); // 加密您的数据
    $decrypted = $pc->decrypt($encrypted); // 解密您的数据
    
    echo $pc->getSeed(); // 获取您设置的种子
    
    $pc->updateSeed('your_new_seed'); // 更新种子
    $encrypted = $pc->encrypt('your_data'); // 使用新的种子加密数据
    $decrypted = $pc->decrypt($encrypted); // 使用新的种子解密数据
   
    $pc->customDict("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"); // 自定义字典
    $encrypted = $pc->encrypt('your_data'); // 使用新的种子加密数据
    $decrypted = $pc->decrypt($encrypted); // 使用新的种子解密数据
    ```

-  使用助手函数
    ```php
    <?php
    // 默认种子 方式1
    $encrypted = petal_encrypt('your_data'); // 加密您的数据
    $decrypted = petal_decrypt($encrypted); // 解密您的数据
    
    // 默认种子 方式2 (和方式1一样，但是没必要这么写)
    $seed = petal_seed();
    $encrypted = petal_encrypt('your_data',$seed); // 加密您的数据
    $decrypted = petal_decrypt($encrypted,$seed); // 解密您的数据
    
    // 自定义种子
    $seed = petal_seed('your_seed'); // 设置种子
    $encrypted = petal_encrypt('your_data',$seed); // 加密您的数据
    $decrypted = petal_decrypt($encrypted,$seed); // 解密您的数据
    
    // 自定义字典
    $seed = petal_custom_dict("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/");
    $encrypted = petal_encrypt('your_data',$seed); // 加密您的数据
    $decrypted = petal_decrypt($encrypted,$seed); // 解密您的数据
    ```

## 示例
- 运行代码
    ```php
    <?php
    $pc = new PetalCipher();
    $encrypt = $pc->encrypt('hello world');
    echo "E1: ".$encrypt."\n";
    $decrypt = $pc->decrypt($encrypt);
    echo "D1: ".$decrypt."\n";
    $encrypt = $pc->encrypt('hello world');
    echo "E2: ".$encrypt."\n";
    $decrypt = $pc->decrypt($encrypt);
    echo "D2: ".$decrypt."\n";
    ```

- 运行结果
    ```base
    E1: yDT5rGDOaIe/HIYQGDb=
    D1: hello world
    E2: IKGQijK7R84jOrowjKs=
    D2: hello world
    ```
## 许可证

- [Apache License 2.0](LICENSE.txt)