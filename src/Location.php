<?php

class Location
{
    private $path;

    public function setPath(string $name)
    {
        $this->path = $name;
    }

    public function getPath()
    {
        return $this->path;
    }
}
