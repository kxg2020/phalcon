<?php
class AES256
{
    // Set cipher method
    private  $cipherMethod ;
    private  $key;
    private  $iv;

    public function __construct()
    {
        $this->setCipherMethod();
        $this->key = hash('sha256','Nothing can take the place of persistence');
        $this->setIv($this->cipherMethod);
    }


    public function encrypt($rawString)
    {
        if(!is_string($rawString)){
            return false;
        }

        // openssl_encrypt uses PKCS#7 padding by default if the options parameter was set to zero
        $cipherMethod = $this->cipherMethod;
        $key = $this->key;
        $iv = $this->iv;

        $encryptedString = base64_encode(openssl_encrypt($rawString, $cipherMethod, $key, 0, $iv));

        return $encryptedString;
    }


    public function decrypt($encryptedString)
    {
        if(!is_string($encryptedString)){
            return false;
        }

        // Decryption
        $cipherMethod = $this->cipherMethod;
        $key = $this->key;
        $iv = $this->iv;

        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $cipherMethod, $key, 0, $iv);

        return $decryptedString;
    }


    public function setCipherMethod()
    {
        $this->cipherMethod =  'AES-256-CBC';
    }


    public function setKey()
    {
        // Set encryption key
        // The key length must be 256 bits long
        $this->key = openssl_random_pseudo_bytes(32);
    }


    public function setIv($cipherMethod)
    {
        // Set initialization vector
        // $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
        $this->iv = substr(hash('sha256',md5($this->key)),0,16);
    }

}
