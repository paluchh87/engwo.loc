<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

function debug($str)
{
    echo '<pre>';
    var_dump($str);
    echo '</pre>';
    exit;
}

function map($items, $func)
{
    $results = array();
    foreach ($items as $item) {
        $results[] = $func($item);
    }
    return $results;
}

function filter($items, $func)
{
    $results = array();
    foreach ($items as $item) {
        if ($func($item)) {
            $results[] = $item;
        }
    }
    return $results;
}

function reject($items, $func)
{
    $results = array();
    foreach ($items as $item) {
        if (!$func($item)) {
            $results[] = $item;
        }
    }

    return $results;
}

function logToFile($name, $item)
{
    if (!empty($item)) {
        $fw = fopen('file.txt', "a");
        fwrite($fw, $name . " " . var_export($item, true));
        fclose($fw);
    }

    return true;
}