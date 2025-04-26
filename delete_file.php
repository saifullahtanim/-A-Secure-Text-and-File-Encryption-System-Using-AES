<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filename'])) {
    $filename = basename($_POST['filename']);
    $filepath = "uploads/" . $filename;

    if (file_exists($filepath)) {
        unlink($filepath); // ফাইল ডিলিট হবে
    }
}

header("Location: view_files.php"); // ব্যাক যাবে তালিকায়
exit();
?>
