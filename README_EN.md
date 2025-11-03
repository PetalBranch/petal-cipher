# Petal Cipher

**Language：** [简体中文](README.md) | <u>👉 English</u>

## Introduction

**PetalBranch/petal-cipher** is a lightweight reversible encryption library based on custom transformation rules.


## Installation

> PHP Version Requirement: >= 5.0 <br>
> ⚠ Development Environment: PHP 8.3. Please test on your own if using a lower version.

- **Install using Composer** (Recommended)
  ```bash
  composer require petalbranch/petal-cipher
  ```
- **Manual Download**

  Download the latest version ZIP file from the GitHub repository:<br>
  https://github.com/PetalBranch/petal-cipher <br>
  Unzip all contents to your project directory, for example: `vendor/PetalBranch/toml` <br>
  In your PHP file, include the autoloader file or manually require the necessary files:
  ```php
  // Load helper functions
  require_once 'vendor/PetalBranch/petal-cipher/src/Helpers.php';
  // Load class files
  require_once 'vendor/PetalBranch/petal-cipher/src/PetalCipher.php';
  ``` 


## How to use

-  Using the class file
    ```php
    <?php
    use Petalbranch\PetalCipher\PetalCipher; // Use the PetalCipher Class
    
    $pc = new PetalCipher('your_seed'); // Create a PetalCipher instance, passing in your seed
    
    $encrypted = $pc->encrypt('your_data'); // Encrypt your data
    $decrypted = $pc->decrypt($encrypted); // Decrypt your data
    
    echo $pc->getSeed(); // Get seed
    
    $pc->updateSeed('your_new_seed'); // Update seed
    $encrypted = $pc->encrypt('your_data'); // Encrypt data using the new seed
    $decrypted = $pc->decrypt($encrypted); // Decrypt data using the new seed
    
    $pc->customDict("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"); // Customize the dictionary
    $encrypted = $pc->encrypt('your_data'); // Encrypt data using the new seed
    $decrypted = $pc->decrypt($encrypted); // Decrypt data using the new seed
    ```

-  Using helper functions
    ```php
    <?php
    // Default seed — Method 1
    $encrypted = petal_encrypt('your_data'); // Encrypt your data
    $decrypted = petal_decrypt($encrypted); // Decrypt your data
    
    // Default seed — Method 2 (same as Method 1, but usually unnecessary to write this way)
    $seed = petal_seed();
    $encrypted = petal_encrypt('your_data',$seed); // Encrypt your data
    $decrypted = petal_decrypt($encrypted,$seed); // Decrypt your data
    
    // Set seed
    $seed = petal_seed('your_seed'); // Set seed
    $encrypted = petal_encrypt('your_data',$seed); // Encrypt your data
    $decrypted = petal_decrypt($encrypted,$seed); // Decrypt your data
   
    // Customize the dictionary
    $seed = petal_custom_dict("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/");
    $encrypted = petal_encrypt('your_data',$seed); // Encrypt your data
    $decrypted = petal_decrypt($encrypted,$seed); // Decrypt your data
    ```

## Example
- Run the code
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

- Output / Result
    ```base
    E1: yDT5rGDOaIe/HIYQGDb=
    D1: hello world
    E2: IKGQijK7R84jOrowjKs=
    D2: hello world
    ```

## License

- [Apache License 2.0](LICENSE.txt)