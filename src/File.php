<?php

class File implements FileInterface
{
    private $from;

    private $to;

    private $location;

    private $line;

    public $DIV = 0;

    public $ADD = 0;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    /**
     * File to taken content.
     *
     * @param string $name
     */
    public function fromFile(string $name)
    {
        $this->from = $name;
    }

    /**
     * When store new content.
     *
     * @param string $name
     */
    public function toFile(string $name)
    {
        $this->to = $name;
    }

    /**
     * Get content any file.
     *
     * @return \File
     */
    public function getContentFromFile() : File
    {
        $content = $this->makeLocationToFile($this->location->getPath(), $this->from);

        return $this->explodeContentToArray(file_get_contents($content));
    }

    /**
     * Explode content any file to array and pass it to saveNewContentToFile method.
     *
     * @param String $content
     */
    public function explodeContentToArray(String $content)
    {
        $param = '';
        $this->line = explode("\n", $content);

        foreach ($this->line as $oneLine) {
            $param .= $this->operation($oneLine);
        }

        $this->saveNewContentToFile($param);
    }

    /**
     * Explode one line and check activities. Bind result to one string.
     *
     * @param String $line
     * @return string
     */
    public function operation(String $line): string
    {
        $paramInLine = explode(' ', $line);

        $firstParamInLine = array_shift($paramInLine);

        $newContent = '';

        switch ($firstParamInLine) {
            case 'ADD':
                foreach ($paramInLine as $param) {
                    (string) $this->ADD += (int) $param;
                }

                $newContent .= 'ADD = '.$this->ADD."\n";
                break;
            case 'DIV':
                $array = [];
                foreach ($paramInLine as $param) {
                    array_push($array, $param);
                }

                if ((int) $array[1] === 0) {
                    (string) $this->DIV = 'DIVISION BY ZERO!';
                } else {
                    (string) $this->DIV = (string) $array[0] / (string) $array[1];
                }

                $newContent .= 'DIV = '.$this->DIV."\n";
                break;
        }

        return $newContent;
    }

    /**
     * Save new content to file.
     *
     * @param string $param
     */
    public function saveNewContentToFile(string $param)
    {
        $contentToSave = $this->makeLocationToFile($this->location->getPath(), $this->to);

        file_put_contents($contentToSave, $param);
    }

    /**
     * make file location.
     *
     * @param string $path
     * @param string $direction TO/FROM
     * @return string
     */
    private function makeLocationToFile(string $path, string $direction) : string
    {
        $locationOfFile = '%s/%s';

        return sprintf($locationOfFile, $path, $direction);
    }
}