<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicPrivateKeyEncryption
{


    /**
     * @param $data
     * @return string Encrypt Data
     */
    function encrypt($data)
    {

        $publicKey = openssl_pkey_get_public('file://'.FCPATH .'codigniter_public.pem');
        $a_key = openssl_pkey_get_details($publicKey);

        openssl_public_encrypt($data, $encrypted, $publicKey);

        openssl_free_key($publicKey);

        return base64_encode($encrypted);

    }

    /**
     * @param $data
     * @return mixed Decrypt String
     */
    function decrypt($data)
    {

        if (!$privateKey = openssl_pkey_get_private('file://'.FCPATH .'codigniter_private.key'))
        {
            die('Private Key failed');
        }

         $ciphertext = base64_decode($data);
         openssl_private_decrypt($ciphertext, $decrypted, $privateKey);

         return $decrypted;

    }

}