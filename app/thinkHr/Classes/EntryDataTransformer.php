<?php
namespace thinkHr\Classes;

use thinkHr\Interfaces\Transformer;

class EntryDataTransformer implements Transformer
{
    
    const FULL_NAME_PARTS_COUNT  = 4;
    const SPLIT_NAME_PARTS_COUNT = 5;
    const VALID_PHONE_STR_LEN    = 12; //account for two spaces


    public function transform($entry_data)
    {
        if(empty($entry_data)) {
            return [];
        }
    
        $first_name = null;
        $last_name  = null;
        $phone      = null;
        $zip_code   = null;
        $color      = null;

        if (count($entry_data) == self::FULL_NAME_PARTS_COUNT) {
            list($first_name, $last_name) = explode(" ", $entry_data[0]);
            $color    = $entry_data[1];
            $zip_code = $entry_data[2];
            $phone    = $this->transformPhone($entry_data[3]);
        } elseif (count($entry_data) == self::SPLIT_NAME_PARTS_COUNT) {
            if (is_numeric($entry_data[2])) {
                $first_name = $entry_data[0];
                $last_name  = $entry_data[1];
                $zip_code   = $entry_data[2];
                $phone      = $this->transformPhone($entry_data[3]);
                $color      = $entry_data[4];

            } else {
                $last_name  = $entry_data[0];
                $first_name = $entry_data[1];
                $phone      = $this->transformPhone($entry_data[2]);
                $color      = $entry_data[3];
                $zip_code   = $entry_data[4];
            }
        }
    
        $output = [
            'first_name' => trim($first_name),
            'last_name'  => trim($last_name),
            'phone'      => trim($phone),
            'zip_code'   => trim($zip_code),
            'color'      => trim($color),
        ];

        return $output;
    }
    
    public function prepareJson($data)
    {
        $json = '';
        
        if (!empty($data)) {
            $json = preg_replace_callback(
                '/^ +/m',
                function ($m) {
                    return str_repeat(' ', strlen($m[0]) / 2);
                },
                json_encode($data, JSON_PRETTY_PRINT)
            );
        }
        
        return $json;
    }
    
    private function transformPhone($phone)
    {
        $phone = trim($phone);
        
        if (strpos($phone, "(") >= 0) {
            $phone = str_replace("(", "", $phone);
        }
    
        if (strpos($phone, ")")) {
            $phone = str_replace(")", "", $phone);
        }
        
        if (strpos($phone, "-")) {
            $phone = str_replace("-", " ", $phone);
        }
        
        //if we want to transform phone numbers w/o spaces or dashes
        //commenting out for now
//        if(strlen($phone) != self::VALID_PHONE_STR_LEN) {
//            $area_code = substr($phone, 0, 3);
//            $prefix    = substr($phone, 3, 3);
//            $suffix    = substr($phone, 6);
//
//            $phone = $area_code . " " . $prefix . " " . $suffix;
//        }
    
        return $phone;
    }
    
    
    
}