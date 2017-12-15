<?php

interface FileInterface
{
    public function getContentFromFile();
    public function operation(String $line);
    public function saveNewContentToFile(array $param);
}