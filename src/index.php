<?php
require_once __DIR__.'/Autoload.php';

$Location = new Location();


$nameOfDirectory = $Location->setPath('C:\Users/Admin/Desktop');

$file = new File($Location);

$nameOfFile = $file->setName('test.txt');

echo $file->getContentFromFile();
