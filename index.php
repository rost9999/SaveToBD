<?php

require_once "./vendor/autoload.php";


$db = new SaveToDB();
$result = $db->save();

if ($result) {
    echo 'save done';
} else {
    echo 'error';
}