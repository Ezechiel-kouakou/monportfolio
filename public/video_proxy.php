<?php
header("Access-Control-Allow-Origin: https://www.ezechielkouakou.fr");

$file = basename($_GET['file'] ?? '');
if (empty($file)) die("Fichier manquant.");

header("Location: https://penguin.tailc4a1d9.ts.net/" . $file);
exit;