<?php
session_start();
$fn = trim($_GET['fn']) ?? '';
$fn = __DIR__ . '/../data/uploads/' . (($fn) ? $fn : 'person.png');
if (file_exists($fn)) {
    header('Content-Type: ' . mime_content_type($fn));
    readfile($fn);
}
