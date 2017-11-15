<?php
namespace thinkHr\Classes;

use JsonSerializable;

/**
 * Class Person
 *
 * @package Classes
 */
class Person implements JsonSerializable
{
    protected $color;
    protected $first_name;
    protected $last_name;
    protected $phone;
    protected $zip_code;
    
    public function __construct(array $personal_data)
    {
        if (isset($personal_data['first_name'])) {
            $this->setFirstName($personal_data['first_name']);
        }
        
        if (isset($personal_data['last_name'])) {
            $this->setLastName($personal_data['last_name']);
        }
        
        if (isset($personal_data['phone'])) {
            $this->setPhone($personal_data['phone']);
        }
        
        if (isset($personal_data['zip_code'])) {
            $this->setZipCode($personal_data['zip_code']);
        }
        
        if (isset($personal_data['color'])) {
            $this->setColor($personal_data['color']);
        }
        
    }
    
    /**
     * @param mixed $color
     *
     * @return Person
     */
    public function setColor($color)
    {
        $this->color = $color;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }
    
    /**
     * @param mixed $first_name
     *
     * @return Person
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }
    
    /**
     * @param mixed $last_name
     *
     * @return Person
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }
    
    /**
     * @param mixed $phone
     *
     * @return Person
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * @param mixed $zip
     *
     * @return Person
     */
    public function setZipCode($zip_code)
    {
        $this->zip_code = $zip_code;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }
    
    function jsonSerialize()
    {
        return get_object_vars($this);
    }
}