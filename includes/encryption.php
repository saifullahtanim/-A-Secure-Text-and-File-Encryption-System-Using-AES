<?php
function encryptFileContent($filePath, $key = 'your-secret-key-123') {
    $data = file_get_contents($filePath);
    $method = "AES-256-CBC";
    $iv = openssl_random_pseudo_bytes(16);
    $encrypted = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);
    return $iv . $encrypted;
}
?>
