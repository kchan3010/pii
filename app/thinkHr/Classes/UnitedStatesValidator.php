<?php
namespace thinkHr\Classes;

use thinkHr\Interfaces\DataValidator;


/**
 * Class UnitedStatesValidator
 *
 * @package Classes
 */
class UnitedStatesValidator implements DataValidator

{
    
    /**
     * @param $phone
     *
     * @return bool
     */
    public function isValidPhone($phone)
    {
        $ret_val = false;
    
        if (preg_match("/^[0-9]{3}\s[0-9]{3}\s[0-9]{4}$/", $phone)) {
            $ret_val = true;
        }
        
        return $ret_val;
    }
    
    public function isValidZipCode($zip_code)
    {
        $ret_val = false;
    
        if (preg_match("/^\d{5}(?:[-\s]\d{4})?$/", $zip_code)) {
            $ret_val = true;
        }
        
        return $ret_val;
    }
}