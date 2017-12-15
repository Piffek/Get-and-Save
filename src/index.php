<?php
require_once __DIR__.'/Location.php';
require_once __DIR__.'/File.php';

$Location = new Location();


$nameOfDirectory = $Location->setName('C:\Users/Admin/Desktop');

$file = new File($Location);

$nameOfFile = $file->setName('test.txt');

echo $file->getContentFromFile();
