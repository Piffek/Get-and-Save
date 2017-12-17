<?php
require_once __DIR__.'/Autoload.php';

$Location = new Location();

$nameOfDirectory = $Location->setPath(__DIR__);

$file = new File($Location);

$file->fromFile('test.txt');

$file->toFile('afterOperation.txt');

$file->getContentFromFile();
