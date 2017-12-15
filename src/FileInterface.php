<?php

interface FileInterface
{
    public function getContentFromFile();
    public function operation(String $line) : string;
    public function saveNewContentToFile(string $param);
}