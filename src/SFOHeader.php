<?php

class SFOHeader
{
    const SFOMagic = 0x46535000;    // "\0PSF"

    private $magic;

    private $version;

    private $key_table_offset;

    private $value_table_offset;

    private $param_count;

    public function __construct($buffer)
    {
        if (strlen($buffer) < 0x14) {
            throw new Exception("Buffer must be at least 0x14 bytes.");
        }

        $header = unpack("L5", $buffer);
        $this->magic = $header[1];
        $this->version = $header[2];
        $this->key_table_offset = $header[3];
        $this->value_table_offset = $header[4];
        $this->param_count = $header[5];

        if ($this->magic != SFOHeader::SFOMagic) {
            throw new Exception("Invalid magic for SFO.");
        }
    }

    public function getKeyTableOffset()
    {
        return $this->key_table_offset;
    }

    public function getValueTableOffset()
    {
        return $this->value_table_offset;
    }

    public function getParamCount()
    {
        return $this->param_count;
    }
}
