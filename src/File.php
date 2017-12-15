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

    public function fromFile(string $name)
    {
        $this->from = $name;
    }

    public function toFile(string $name)
    {
        $this->to = $name;
    }

    public function getContentFromFile()
    {
        $locationOfFile = '%s/%s';
        $content = sprintf($locationOfFile, $this->location->getPath(), $this->from);

        return $this->explodeContentToArray(file_get_contents($content));
    }

    public function explodeContentToArray(String $content)
    {
        $param = [];
        $this->line = explode("\n", $content);

        foreach ($this->line as $oneLine) {
            array_push($param, $this->operation($oneLine));
        }

        $this->saveNewContentToFile($param);
    }

    public function operation(String $line)
    {
        $paramInLine = explode(' ', $line);

        $firstParamInLine = array_shift($paramInLine);

        switch ($firstParamInLine) {
            case 'ADD':
                foreach ($paramInLine as $param) {
                    (string) $this->ADD += (int) $param;
                }

                return 'ADD = '.$this->ADD;
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

                return 'DIV = '.$this->DIV;
                break;
        }
    }

    public function saveNewContentToFile(array $param)
    {
        $locationOfFile = '%s/%s';
        $content = sprintf($locationOfFile, $this->location->getPath(), $this->to);

        $paramToSave = '';
        foreach ($param as $result) {
            $paramToSave .= $result."\n";
        }

        file_put_contents($content, $paramToSave);
    }
}