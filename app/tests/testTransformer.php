<?php

use PHPUnit\Framework\TestCase;
use thinkHr\Classes\EntryDataTransformer;

require_once __DIR__ . '../thinkHr/Classes/EntryDataTransformer.php';

/**
 * Class testTransformer
 */
class testTransformer extends TestCase
{
    protected $transformer;
    
    public function setup()
    {
        $this->transformer = new EntryDataTransformer();
    }
    
    public function testKenny()
    {
        $this->assertEquals(1,1);
    }
}