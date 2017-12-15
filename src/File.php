<?php

class File implements FileInterface
{
    private $name;
    private $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getContentFromFile()
    {
        $locationOfFile = '%s/%s';
        $content = sprintf($locationOfFile, $this->location->getPath(), $this->name);
        return file_get_contents($content);
    }

    public function operation()
    {

    }

    public function saveNewContentToFile()
    {

    }

}