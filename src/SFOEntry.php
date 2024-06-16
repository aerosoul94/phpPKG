<?php

/**
 * SFO entry parser.
 */
class SFOEntry 
{
    private $key_offset;

    private $value_format;

    private $value_length;

    private $value_max_length;

    private $value_offset;

    public function __construct($buffer)
    {
        if (strlen($buffer) != 0x10) {
            throw new Exception("Buffer must be 0x10 bytes.");
        }

        $data = unpack("S2", $buffer);
        $this->key_offset = $data[1];
        $this->value_format = $data[2];
        $data = unpack("L3", $buffer, 4);
        $this->value_length = $data[1];
        $this->value_max_length = $data[2];
        $this->value_offset = $data[3];
    }

    /**
     * Returns the size of this SFO Entry structure.
     */
    public static function getSize()
    {
        return 0x10;
    }

    /**
     * Returns the offset of the key for this entry.
     */
    public function getKeyOffset()
    {
        return $this->key_offset;
    }

    /**
     * Returns the format of the value.
     */
    public function getValueFormat()
    {
        return $this->value_format;
    }

    /**
     * Returns the length of the value.
     */
    public function getValueLength()
    {
        return $this->value_length;
    }

    /**
     * Returns the max length of the value.
     */
    public function getValueMaxLength()
    {
        return $this->value_max_length;
    }

    /**
     * Returns the offset of the value for this entry.
     */
    public function getValueOffset()
    {
        return $this->value_offset;
    }
}