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

    public function setFromFile(string $name)
    {
        $this->from = $name;
    }

    public function setToFile(string $name)
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
        $arrayOfParam = explode(' ', $line);

        $firstParam = array_shift($arrayOfParam);

        switch ($firstParam) {
            case 'ADD':
                foreach ($arrayOfParam as $param) {
                    $this->ADD += (int) $param;
                }

                return 'ADD = '.$this->ADD;
                break;
            case 'DIV':
                $array = [];
                foreach ($arrayOfParam as $param) {
                    array_push($array, $param);
                }
                $this->DIV = $array[0] / $array[1];

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
            $paramToSave .= $result . "\n";
        }

        file_put_contents($content, $paramToSave);
    }
}