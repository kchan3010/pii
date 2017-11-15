<?php
/**
 * Interface validator
 */

namespace thinkHr\Interfaces;

interface DataValidator
{
    public function isValidPhone($phone);
    
    public function isValidZipCode($zip_code);
    
}