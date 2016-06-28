<?php
/**
 * Created by PhpStorm.
 * User: apengZhang
 * Date: 16/6/23
 * Time: 18:35
 */
class Driver3Des extends Driver{

    /**
     * 3Des加密
     * @param $input
     * @return string
     */
    public static function encrypt($input) {
        $size = mcrypt_get_block_size(MCRYPT_3DES, RC('encrypt_config', '3des_model'));
        $input = self :: _pkcs5_pad($input, $size);
        $key = str_pad(RC('encrypt_config', '3des_key'),24,'0');
        $td = mcrypt_module_open(MCRYPT_3DES, '', RC('encrypt_config','3des_model'), '');
        $iv = RC('encrypt_config', '3des_iv') ? RC('encrypt_config', '3des_iv') : @mcrypt_create_iv(mcrypt_enc_get_iv_size($td),MCRYPT_RAND);
        @mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }

    /**
     * 3Des解密
     * @param $encrypted
     * @return bool|string
     */
    public static function decrypt($encrypted) {
        $encrypted = base64_decode($encrypted);
        $key = str_pad(RC('encrypt_config', '3des_key'),24,'0');
        $td = mcrypt_module_open(MCRYPT_3DES,'',RC('encrypt_config','3des_model'),'');
        $iv = RC('encrypt_config', '3des_iv') ? RC('encrypt_config','3des_iv') : @mcrypt_create_iv(mcrypt_enc_get_iv_size($td),MCRYPT_RAND);
        $ks = mcrypt_enc_get_key_size($td);
        @mcrypt_generic_init($td, $key, $iv);
        $decrypted = mdecrypt_generic($td, $encrypted);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $y = self :: _pkcs5_unpad($decrypted);
        return $y;
    }

    private static function _pkcs5_pad ($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    private static function _pkcs5_unpad($text) {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);

    }

}