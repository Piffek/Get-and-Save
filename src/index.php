<?php
require_once __DIR__.'/Autoload.php';

$Location = new Location();

$nameOfDirectory = $Location->setPath(__DIR__.'./');

$file = new File($Location);

$file->setFromFile('test.txt');

$file->setToFile('afterOperation.txt');

$file->getContentFromFile();
