<?php
function decryptText($cipher, $key = 'secretkey123') {
    return openssl_decrypt($cipher, "AES-256-CBC", $key, 0, str_repeat("0", 16));
}
?>

