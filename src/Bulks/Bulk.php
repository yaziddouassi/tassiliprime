<?php
namespace Tassili\Prime\Bulks;

class Bulk
{
    protected string $field;
    protected array $options = [];
     
    
    public static function make(string $field): self
    {
        $instance = new self();
        $instance->field = $field;
        return $instance;
    }

    public function params($a)
    {
       $this->options = $a ;
       return $this ;
    }

    
    public function registerTo($generator): void
    {
        $generator->bulks[$this->field] = $this->options;
        $generator->bulkTabs[$this->field] = array();
       
    }

}