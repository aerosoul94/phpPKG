<?php

require 'UCPEntry.php';
require 'UCPHeader.php';

class UCPFile
{
    private $entries = array();
    private $header;

    public function __construct($buffer)
    {
        $this->header = new UCPHeader($buffer);

        $table_offset = 0x50;
        $entry_size = $this->header->getEntrySize();
        $table_end = $this->header->getEntryCount() * $entry_size;

        for (; $table_offset < $table_end; $table_offset += $entry_size) {
            $data = substr($buffer, $table_offset, $entry_size);
            $entry = new UCPEntry($data);

            array_push($entries, $entry);
        }
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function getEntryCount()
    {
        return $this->header->getEntryCount();
    }
}