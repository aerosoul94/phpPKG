<?php

class PKGHeader
{
    private $metadata_table_count;

    private $metadata_table_offset;
    
    private $metadata_table_size;

    public function __construct($buffer)
    {
        $this->metadata_table_count  = unpack("N", $buffer, 0x10)[1];
        $this->metadata_table_offset = unpack("N", $buffer, 0x18)[1];
    }

    public function getMetadataTableOffset()
    {
        return $this->metadata_table_offset;
    }

    public function getMetadataTableCount()
    {
        return $this->metadata_table_count;
    }
}
