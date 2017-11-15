<?php
namespace thinkHr\Classes;

use thinkHr\Interfaces\Transformer;
use thinkHr\Interfaces\DataValidator;

class PersonalIdentifier
{

    protected $parser;
    protected $validator;
    protected $entries;
    protected $errors = [];
    protected $line_counter = 1;
    protected $transformer;

    public function __construct(DataValidator $validator, Transformer $transformer)
    {
        $this->setValidator($validator);
        $this->setTransformer($transformer);
    }
    
    /**
     * @param $entry_data
     *
     * @return bool
     */
    public function process($entry_data)
    {
        if (count($entry_data) < EntryDataTransformer::FULL_NAME_PARTS_COUNT ||
            count($entry_data) > EntryDataTransformer::SPLIT_NAME_PARTS_COUNT
        ) {
            $this->errors[] = $this->line_counter;
            $this->line_counter++;
            return false;
        }
        
        $parsed_data = $this->parse($entry_data);
    
        if(empty($parsed_data)) {
            return false;
        }
        
        $person = new Person($parsed_data);
        $this->entries[] = $person->jsonSerialize();
    
        $this->line_counter++;
        
        return true;
    }
    
    /**
     * @param string $filename
     */
    public function getResults($filename='output.txt')
    {
        $results = [];
        
        if (!empty($this->getEntries())) {
            $this->sortEntries();
            $results['entries'] = $this->getEntries();
        }
        
        if (!empty($this->getErrors())) {
            $results['errors'] = $this->getErrors();
        }
        
        $data = $this->getTransformer()->prepareJson($results);
        
        if (empty($data)) {
            $data = "Error in preparing JSON";
        }
        
        file_put_contents($filename, $data);
    }

    /**
     * @param mixed $validator
     * @return PersonalIdentifier
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidator()
    {
        return $this->validator;
    }
    
    /**
     * @return mixed
     */
    public function getEntries()
    {
        return $this->entries;
    }
    
    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * @param mixed $transformer
     *
     * @return PersonalIdentifier
     */
    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getTransformer()
    {
        return $this->transformer;
    }
    
    /**
     * @param $entry_data
     *
     * @return array
     */
    private function parse($entry_data)
    {
        $transformed_data = $this->getTransformer()->transform($entry_data);
        
        //let's normalize the data first and then validate phone number
        if (!$this->getValidator()->isValidPhone($transformed_data['phone'])) {
            $this->errors[]   = $this->line_counter;
            $transformed_data = [];
        }
        
        return $transformed_data;
    }
    
    private function sortEntries()
    {
        if (empty($this->getEntries())) {
            return [];
        }
        
        foreach($this->entries as $key=>$entry) {
            $first_name[$key] = $entry['first_name'];
            $last_name[$key]  = $entry['last_name'];
        }
    
        array_multisort($first_name, SORT_ASC, $last_name, SORT_ASC, $this->entries);
    }
}