<?php
function decryptFileContent($filepath, $key = 'your-secret-key-123') {
    $data = file_get_contents($filepath);
    $method = "AES-256-CBC";
    $iv = substr($data, 0, 16);
    $ciphertext = substr($data, 16);
    return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
}
?>
