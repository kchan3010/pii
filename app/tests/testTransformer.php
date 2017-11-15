<?php

use PHPUnit\Framework\TestCase;
use thinkHr\Classes\EntryDataTransformer;

/**
 * Class testTransformer
 */
class testTransformer extends TestCase
{
    protected $transformer;
    protected $full_name_input;
    protected $split_name_input_1;
    protected $split_name_input_2;
    
    public function setUp()
    {
        $this->transformer = new EntryDataTransformer();
        
        $this->full_name_input = [
            "Kenny Chan",
            "lime green",
            "94105",
            "123 456 7890"
        ];
    
        $this->split_name_input_1 = [
            "Kenny",
            "Chan",
            "94106",
            "123 456 7890",
            "blue"
        ];
    
        $this->split_name_input_2 = [
            "Chan",
            "Kenny",
            "123 456 7890",
            "pink",
            "94107"
        ];
    
    }
    
    public function testTransformerWithEmptyData()
    {
        $input = [];
        
        $result = $this->transformer->transform($input);
        $this->assertEmpty($result);
    }
    
    public function testTransformerWithTooManyKeys()
    {
        array_push($this->split_name_input_1, 'some value');
        $result = $this->transformer->transform($this->split_name_input_1);
    
        $this->assertEmpty($result);
    }

    public function testTransformerWithTooMLittleKeys()
    {
        array_shift($this->full_name_input);
        $result = $this->transformer->transform($this->full_name_input);
    
        $this->assertEmpty($result);
    }

    public function testTransformerKeys()
    {
        $result = $this->transformer->transform($this->full_name_input);
        
        $count = count($result);
        $this->assertGreaterThan(0, $count);
        $this->assertArrayHasKey('first_name', $result);
        $this->assertArrayHasKey('last_name', $result);
        $this->assertArrayHasKey('color', $result);
        $this->assertArrayHasKey('zip_code', $result);
        $this->assertArrayHasKey('phone', $result);
    }
    
    public function testTransformerWithFullName()
    {
        $result = $this->transformer->transform($this->full_name_input);
        
        $this->assertEquals('Kenny', $result['first_name']);
        $this->assertEquals('Chan', $result['last_name']);
        $this->assertEquals($this->full_name_input[1], $result['color']);
        $this->assertEquals($this->full_name_input[2], $result['zip_code']);
        $this->assertEquals($this->full_name_input[3], $result['phone']);
    }
    
    public function testTransformerWithSplitName1()
    {
        $result = $this->transformer->transform($this->split_name_input_1);
        
        $this->assertEquals($this->split_name_input_1[0], $result['first_name']);
        $this->assertEquals($this->split_name_input_1[1], $result['last_name']);
        $this->assertEquals($this->split_name_input_1[2], $result['zip_code']);
        $this->assertEquals($this->split_name_input_1[3], $result['phone']);
        $this->assertEquals($this->split_name_input_1[4], $result['color']);
    }
    
    public function testTransformerWithSplitName2()
    {
        $result = $this->transformer->transform($this->split_name_input_2);
        
        $this->assertEquals($this->split_name_input_2[0], $result['last_name']);
        $this->assertEquals($this->split_name_input_2[1], $result['first_name']);
        $this->assertEquals($this->split_name_input_2[2], $result['phone']);
        $this->assertEquals($this->split_name_input_2[3], $result['color']);
        $this->assertEquals($this->split_name_input_2[4], $result['zip_code']);
    }
    
    public function testTransformerPhoneWithDashes()
    {
        $this->split_name_input_1[3] = '(123)-456-7890';
        
        $result = $this->transformer->transform($this->split_name_input_1);
        
        $this->assertEquals('123 456 7890', $result['phone']);
    }
    
    public function testTransformerPhoneWithNoDashes()
    {
        $this->split_name_input_1[3] = '123 456 7890';
        
        $result = $this->transformer->transform($this->split_name_input_1);
        
        $this->assertEquals('123 456 7890', $result['phone']);
    }
    
    
}