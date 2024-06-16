<?php

class MetadataEntry
{
    private $id;
    private $name_offset;
    private $flags;
    private $attributes;
    private $offset;
    private $length;

    public function __construct($buffer)
    {
        if (strlen($buffer) != 0x20) {
            throw new Exception("Buffer must be 0x20 bytes.");
        }

        $data = unpack("N6", $buffer, 0x0);
        $this->id = $data[1];
        $this->name_offset = $data[2];
        $this->flags = $data[3];
        $this->attributes = $data[4];
        $this->offset = $data[5];
        $this->length = $data[6];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNameOffset()
    {
        return $this->name_offset;
    }

    public function getFlags()
    {
        return $this->flags;
    }

    public function getAttributes()
    {
        return $this->attributes;
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
