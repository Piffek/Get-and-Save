<?php

class Location
{
    private $path;

    /**
     * Set path to file.
     *
     * @param string $name
     */
    public function setPath(string $name)
    {
        $this->path = $name;
    }

    /**
     * Get path to file.
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }
}
