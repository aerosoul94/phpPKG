<?php

class Utility
{
    public static function getContents($url, $offset, $length)
    {
        $end = ($offset + $length - 1);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RANGE, $offset . "-" . $end);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $buffer = curl_exec($ch);

        if ($buffer == false) {
            echo curl_errno($ch);
            $error = curl_error($ch);
            var_dump($error);
            echo "Curl error: " . $error . PHP_EOL;
        } else {
            echo "Downloaded: " . strlen($buffer) . " bytes." . PHP_EOL;
        }

        curl_close($ch);

        return $buffer;
    }

    public static function getString($buffer, $offset)
    {
        $str = "";
        for ($i = $offset; $i < strlen($buffer); $i++) {
            if ($buffer[$i] == "\0") {
                break;
            }
            $str .= $buffer[$i];
        }
        return $str;
    }
}