<?php

require('MetadataId.php');
require('MetadataEntry.php');
require('PKGHeader.php');
require_once('Utility.php');

/**
 * Remote PKG reader.
 */
class PKGFile
{
    private $initial_url;

    private $initial_buffer;

    const InitialBufferSize = 0x10000;

    private $header;

    private $metadata_table;

    private $metadata_table_count;

    private $metadata_entries = array();

    private $metadata_name_table;

    public function __construct($url)
    {
        $this->initial_url = $url;
        $this->initial_buffer = Utility::getContents(
            $this->initial_url,
            0,
            PKGFile::InitialBufferSize
        );

        //file_put_contents("header.bin", $this->initial_buffer);

        $read_len = strlen($this->initial_buffer);
        //echo "Header read length: " . $read_len . PHP_EOL;
        if ($read_len != PKGFile::InitialBufferSize) {
            throw new Exception(
                "Did not receive required amount of data for header."
            );
        }

        $this->header = new PKGHeader($this->initial_buffer);

        $table_offset = $this->header->getMetadataTableOffset();
        $table_count = $this->header->getMetadataTableCount();
        $table_size = $table_count * 0x20;

        $this->metadata_table = $this->getContents($table_offset, $table_size);
        $this->metadata_table_count = $table_count;

        for ($i = 0; $i < $this->metadata_table_count; $i++) {
            $data = substr($this->metadata_table, $i * 0x20, 0x20);
            $entry = new MetadataEntry($data);
            array_push($this->metadata_entries, $entry);
        }

        $this->metadata_name_table = $this->getMetadataById(
            MetadataId::MetadataNameTable
        );
    }

    /**
     * Get a list of all metadata entries.
     * 
     * @returns array List of metadata entries
     */
    public function getMetadataEntries()
    {
        return $this->metadata_entries;
    }
    
    /**
     * Get the name of a metadata file by it's entry.
     * 
     * @param MetadataEntry $entry The metadata entry.
     */
    public function getNameForEntry($entry)
    {
        return Utility::getString(
            $this->metadata_name_table,
            $entry->getNameOffset()
        );
    }

    /**
     * Get the name of a metadata file by it's id.
     * 
     * @param integer $id The metadata id (See MetadataId).
     */
    public function getNameForId($id)
    {
        $entry = NULL;
        for ($i = 0; $i < $this->metadata_table_count; $i++) {
            $tmp = $this->metadata_entries[$i];

            if ($tmp->getId() == $id) {
                $entry = $tmp;
                break;
            }
        }

        if ($entry == NULL) {
            return NULL;
        }

        return Utility::getString(
            $this->metadata_name_table,
            $entry->getNameOffset()
        );
    }

    /**
     * Get metadata by it's metadata id.
     * 
     * @param integer $id The metadata id (See MetdataId).
     * @returns string The data for a metadata file.
     */
    public function getMetadataById($id)
    {
        $entry = NULL;
        for ($i = 0; $i < $this->metadata_table_count; $i++) {
            $tmp = $this->metadata_entries[$i];

            if ($tmp->getId() == $id) {
                $entry = $tmp;
                break;
            }
        }

        if ($entry == NULL) {
            return NULL;
        }

        $data_offset = $entry->getOffset();
        $data_length = $entry->getLength();

        $data = $this->getContents($data_offset, $data_length);

        $read_len = strlen($data);
        assert($read_len == $data_length);

        return $data;
    }

    /**
     * Get metadata by it's name.
     * 
     * @param string $name The name of the metadata file.
     * @return string The data for the metadata file.
     */
    public function getMetadataByName($name)
    {
        $entry = NULL;
        for ($i = 0; $i < $this->metadata_table_count; $i++) {
            $tmp = $this->metadata_entries[$i];

            $entry_name = Utility::getString(
                $this->metadata_name_table,
                $tmp->getNameOffset()
            );

            if (strcmp($entry_name, $name) == 0) {
                $entry = $tmp;
                break;
            }
        }

        if ($entry == NULL) {
            return NULL;
        }

        $data_offset = $entry->getOffset();
        $data_length = $entry->getLength();

        $data = $this->getContents($data_offset, $data_length);

        $read_len = strlen($data);
        assert($read_len == $data_length);

        return $data;
    }

    /**
     * Get metadata by it's entry.
     * 
     * @param MetadataEntry $entry The entry to get data for.
     * @return string The data for the metadata file.
     */
    public function getMetadataByEntry($entry)
    {
        $data_offset = $entry->getOffset();
        $data_length = $entry->getLength();

        $data = $this->getContents($data_offset, $data_length);

        $read_len = strlen($data);
        assert($read_len == $data_length);

        return $data;
    }

    private function getContents($offset, $length)
    {
        $data = NULL;
        if (
            $offset > PKGFile::InitialBufferSize ||
            $offset + $length > PKGFile::InitialBufferSize
        ) {
            $data = Utility::getContents(
                $this->initial_url,
                $offset,
                $length
            );
        } else {
            $data = substr($this->initial_buffer, $offset, $length);
        }

        return $data;
    }
}
