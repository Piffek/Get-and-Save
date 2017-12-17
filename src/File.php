<?php

class File implements FileInterface
{
    private $from;

    private $to;

    private $location;

    private $line;

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

        $processing = array_shift($paramInLine);

        $newContent = '';

        $result = 0;
        switch ($processing) {
            case 'ADD':
                foreach ($paramInLine as $param) {
                    (int) $result += (int) $param;
                }

                break;
            case 'DIV':
                try{
                    $array = [];
                    foreach ($paramInLine as $param) {
                        array_push($array, $param);
                    }
                    $result = (int) $array[0] / (int) $array[1];
                    throw new DivisionByZeroError('DIVISION BY ZERO');
                }catch(DivisionByZeroError $e){
                    $result = $e->getMessage();
                }

                break;
            case 'SUB':
                try {
                    foreach ($paramInLine as $param) {
                        $result -= (int) $param;
                    }
                    throw new Exception('String is not acceptable');
                } catch(Exception $e) {
                    $result =  $e->getMessage();
                }
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

        file_put_contents($contentToSave, $param);
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