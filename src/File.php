<?php

class File implements FileInterface
{
    private $from;

    private $to;

    private $location;

    private $line;

    private $content;

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
        $this->content = fread($opennedFile, filesize($file));
        fclose($opennedFile);

        return $this->explodeContentToArray();
    }

    /**
     * Explode content any file to array and pass it to saveNewContentToFile method.
     *
     * @param String $content
     */
    public function explodeContentToArray()
    {
        $param = '';
        $this->line = explode("\n", (string) $this->content);

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
    public function operation(string $line): string
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

                try {
                    $result = (int) $array[0] / (int) $array[1];
                } catch (DivisionByZeroError $e) {
                    throw new DivisionByZeroError('DIVISION BY ZERO');
                }

                break;
            case 'SUB':
                $arrayToSub = [];
                foreach ($paramInLine as $param) {
                    array_push($arrayToSub, $param);
                }

                $result = $arrayToSub[0] - $arrayToSub[1];
                break;
        }

        return $line.' = '.$result."\n";
    }

    /**
     * Save new content to file.
     *
     * @param string $param
     */
    public function saveNewContentToFile(string $param)
    {
        $contentToSave = $this->makeLocationToFile($this->location->getPath(), $this->to);

        $content = fopen($contentToSave, 'w');
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