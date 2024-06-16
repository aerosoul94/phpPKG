<?php

class UCPEntry
{
    private $file_name;
    private $offset;
    private $length;

    public function __construct($buffer)
    {
        $data = unpack("JJ", $buffer, 0x20);
        $this->file_name = substr($buffer, 0, 0x20);
        $this->offset = $data[1];
        $this->length = $data[2];
    }

    public function getFileName()
    {
        return $this->file_name;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function getLength()
    {
        return $this->length;
    }
}