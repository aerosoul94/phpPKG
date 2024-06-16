<?php

class UCPHeader
{
    const UCPMagic = 0x0AC628B2;

    private $magic;
    private $version;
    private $unknown1;
    private $size;
    private $entry_count;
    private $entry_size;
    private $unknown2;
    private $hash;

    public function __construct($buffer)
    {
        if (strlen($buffer) < 0x60) {
            throw new Exception("Buffer must be at least 0x60 bytes.");
        }

        $header = unpack("N7", $buffer);
        $this->magic = $header[1];
        $this->version = $header[2];
        $this->unknown1 = $header[3];
        $this->size = $header[4];
        $this->entry_count = $header[5];
        $this->entry_size = $header[6];
        $this->unknown2 = $header[7];
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getEntryCount()
    {
        return $this->entry_count;
    }

    public function getEntrySize()
    {
        return $this->entry_size;
    }
}