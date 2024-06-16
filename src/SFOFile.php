<?php

require 'SFOEntry.php';
require 'SFOHeader.php';
require_once('Utility.php');

class SFOFile
{
    private $entries = array();

    private $header;

    public function __construct($buffer)
    {
        $this->header = new SFOHeader($buffer);

        $table_offset = 0x14;
        $entry_size = SFOEntry::getSize();
        $table_end = $this->header->getParamCount() * $entry_size;

        for (; $table_offset < $table_end; $table_offset += $entry_size) {
            $data = substr($buffer, $table_offset, $entry_size);
            $entry = new SFOEntry($data);

            $key = Utility::getString(
                $buffer, 
                $this->header->getKeyTableOffset() + $entry->getKeyOffset()
            );
            $value = $this->extractValue($buffer, $entry);

            $this->entries[$key] = $value;
        }
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->entries)) {
            return $this->entries[$key];
        }
        return NULL;
    }

    public function getParams()
    {
        return $this->entries;
    }

    private function extractValue($buffer, $entry)
    {
        $value_table = $this->header->getValueTableOffset();
        $value_offset = $entry->getValueOffset();
        $value_length = $entry->getValueLength();
        $type = $entry->getValueFormat();

        if ($type == 0x404) {
            return unpack("L", $buffer, $value_table + $value_offset)[1];
        } else {
            return substr($buffer, $value_table + $value_offset, $value_length);
        }
    }
}
