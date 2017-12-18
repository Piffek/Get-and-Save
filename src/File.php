<?php

class File implements FileInterface
{
    private $from;

    private $to;

    private $location;

    private $line;

    private $content;

    private $countOfline;

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
    public function getContentFromFile()
    {
        $file = $this->makeLocationToFile($this->location->getPath(), $this->from);

        $opennedFile = fopen($file, 'r');

        $text = $this->lineSet($opennedFile);

        fclose($opennedFile);

        $this->saveNewContentToFile($text);
    }

    private function lineSet($opennedFile)
    {
        $lineSet = '';

        while (! feof($opennedFile)) {
            $lineSet .= $this->operation(fgets($opennedFile));
            $this->countOfline++;
        }

        return $lineSet;
    }

    /**
     * Explode one line and check activities. Bind result to one string.
     *
     * @param String $line
     * @return string
     */
    public function operation($line)
    {
        $paramInLine = explode(' ', $line);

        $processing = array_shift($paramInLine);

        $result = 0;
        switch ($processing) {
            case 'ADD':
                foreach ($paramInLine as $param) {
                    (int) $result += (int) $param;
                }

                break;
            case 'DIV':
                $array = [];
                foreach ($paramInLine as $param) {
                    array_push($array, $param);
                }

                $result = $this->ifSecondParamIsZero($array);

                break;
            case 'SUB':
                $arrayToSub = [];
                foreach ($paramInLine as $param) {
                    array_push($arrayToSub, $param);
                }

                $result = (int) $arrayToSub[0] - (int) $arrayToSub[1];
                break;
        }

        return trim(preg_replace('/\s\s+/', ' ', $line)).' = '.$result."\n";
    }

    private function ifSecondParamIsZero($array)
    {
        if ($array[1] == 0) {
            return (new DivisionByZeroError("DIVISION BY ZERO"))->getMessage();
        } else {
            return (int) $array[0] / (int) $array[1];
        }
    }

    /**
     * Save new content to file.
     *
     * @param string $param
     */
    public function saveNewContentToFile(string $param)
    {
        $fileToSave = $this->makeLocationToFile($this->location->getPath(), $this->to);

        $content = fopen($fileToSave, 'w');
        fwrite($content, $param);
        fclose($content);
    }

    /**
     * make file location.
     *
     * @param string $path
     * @param string $direction TO/FROM
     * @return string
     */
    private function makeLocationToFile(string $path, string $direction): string
    {
        $locationOfFile = '%s/%s';

        return sprintf($locationOfFile, $path, $direction);
    }
}