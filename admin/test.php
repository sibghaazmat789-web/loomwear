<?php

$folder = __DIR__ . "/../uploads/products/";

echo "Folder: " . $folder . "<br>";

if (!is_dir($folder)) {
    die("Folder does not exist.");
}

if (!is_writable($folder)) {
    die("Folder is NOT writable.");
}

$file = $folder . "test.txt";

if (file_put_contents($file, "Hello LoomWear")) {
    echo "Folder is writable.";
} else {
    echo "Cannot write to folder.";
}