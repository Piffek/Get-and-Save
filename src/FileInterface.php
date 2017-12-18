<?php

interface FileInterface
{
    public function getContentFromFile();
    public function operation($line);
    public function saveNewContentToFile(string $param);
}