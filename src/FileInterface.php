<?php

interface FileInterface
{
    public function getContentFromFile();
    public function operation();
    public function saveNewContentToFile();
}