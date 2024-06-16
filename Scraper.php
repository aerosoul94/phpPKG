<?php

require './src/PKGFile.php';
require './src/SFOFile.php';
require './src/Platform.php';

class Scraper
{
    public static function run()
    {
        // Load our database
        // $contents = file_get_contents("database.json");
        // $database = json_decode($contents);

        // foreach ($database as $value) {
        //     // Read the json file
        //     $contents = file_get_contents($value->reference_package_url);
        //     $json = json_decode($contents);
        //     $pkg_url = $json->pieces[0]->url;
        //     echo $pkg_url . PHP_EOL;

        //     Scraper::processPackage($pkg_url);

        //     break;
        // }

        $platform = Platform::PlatformPS5;

        if ($platform == Platform::PlatformPS4) {
            Scraper::processPackage(
                $platform,
                "http://gs2.ww.prod.dl.playstation.net/gs2/ppkgo/prod/CUSA00001_00/9/f_ef965b581d35637dabc96366f29f1f0ece58c8fa9158b0eb7de9407ae72272e8/f/IP9100-CUSA00001_00-PLAYROOM00000000-A0107-V0100.pkg"
            );
        } elseif ($platform == Platform::PlatformPS5) {
            Scraper::processPackage(
                $platform,
                "https://sgst.prod.dl.playstation.net/sgst/prod/00/PPSA01832_00/app/info/9/f_3e891fd62f8dec9017cd2a1836f716f9a2b79ee35d2cffdef443ec9ce3200b49/EP2333-PPSA01832_00-MAQUETTESIEE0000_sc.pkg"
            );
        }
    }

    public static function processPackage($platform, $pkg_url)
    {
        // Load the pkg from a network stream
        $pkg = new PKGFile($pkg_url);

        if ($platform == Platform::PlatformPS4) {
            // You can get sfo by MetadataId
            $sfo_buffer = $pkg->getMetadataById(MetadataId::ParamSfo);
            // You can also get sfo by name
            //$sfo_buffer = $pkg->getMetadataByName("param.sfo");
            //file_put_contents("param.sfo", $sfo_buffer);
            
            $xml_buffer = $pkg->getMetadataById(MetadataId::ChangeInfo_Xml);
            //file_put_contents("changeinfo.xml", $xml_buffer);

            $parser = xml_parser_create();
            $xml = xml_parse($parser, $xml_buffer);
            echo $xml . PHP_EOL;
            if ($sfo_buffer != NULL) {
                echo "Parsing SFO" . PHP_EOL;

                // Load the sfo
                $sfo = new SFOFile($sfo_buffer);

                // Print out all key-value pairs
                $params = $sfo->getParams();
                echo count($params) . " Entries" . PHP_EOL;
                foreach ($params as $key => $value) {
                    echo $key . " = " . $value . PHP_EOL;
                }
            }
        } elseif ($platform == Platform::PlatformPS5) {
            // $buffer = $pkg->getMetadataByName("param.json");
            // file_put_contents("param.json", $buffer);
            $buffer = $pkg->getMetadataById(MetadataId::Trophy2Trophy00Ucp);
            //file_put_contents("../trophy.ucp", $buffer);
            $ucp = new UCPFile($buffer);
            $entries = $ucp->getEntries();
            
            for ($i = 0; $i < $ucp->getEntryCount(); $i++) {
                echo $entries[i]->getFileName();
                echo $entries[i]->getOffset();
                echo $entries[i]->getLength();
            }
        }
    }
}
