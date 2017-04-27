<?php
    function sanitize_filename($fname) {
        $clean = str_replace('/', '', $fname);
        $clean = str_replace('..', '', $clean);
        return $clean;
    }

    $name = "../../../testdata";
    $name = sanitize_filename($name);
    $filename = $_SERVER['DOCUMENT_ROOT'] . "/../data/{$name}.txt";
    echo "<p>\$filename is {$filename}</p>\n";
?>