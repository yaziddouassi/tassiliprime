<?php
namespace Tassili\Prime\Fields;

class Number
{
    protected string $field;
    protected string $type = 'Number';
    protected $defaultValue = '';
    protected $label = '';
    protected $noDatabase = 'no';
    protected $min = 'inifinite';
    protected $max = 'inifinite';
    protected $step = 1;
    protected $readOnly = 'no';
    protected $colSpan = ['sm' =>  1 , 'md' => 1 , 'lg' => 1 , 'xl' => 1];

    public static function make(string $field): self
    {
        $instance = new self();
        $instance->field = $field;
        $instance->label = ucfirst($field);
        return $instance;
    }

    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function value($value): self
    {
        $this->defaultValue = $value;
        return $this;
    }


    public function min($value): self
    {
        $this->min = $value;
        return $this;
    }

    public function max($value): self
    {
        $this->max = $value;
        return $this;
    }

     public function step($value): self
    {
        $this->step = $value;
        return $this;
    }

    public function notInDatabase(): self
    {
        $this->noDatabase = 'yes';
        return $this;
    }

      public function readOnly(): self
    {
        $this->readOnly = 'yes';
        return $this;
    }

       public function colSpan(array $colSpan): self
    {
        $this->colSpan = $colSpan;
        return $this;
    }

     public function registerToCustomAction($generator): void
    {

        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['field'] = $this->field;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['type'] = $this->type;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['value'] = $this->defaultValue;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['label'] = $this->label;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['defaultValue'] = $this->defaultValue;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['noDatabase'] = $this->noDatabase;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['min'] = $this->min;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['max'] = $this->max;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['step'] = $this->step;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['readOnly'] = $this->readOnly;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['colSpan'] = $this->colSpan;
    }   


    
     public function repeteurToCustomAction($generator , $field) {
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['field'] = $this->field;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['type'] = $this->type;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['value'] = $this->defaultValue;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['options']['label'] = $this->label ;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['options']['defaultValue'] = $this->defaultValue ;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['options']['noDatabase'] = $this->noDatabase ;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['options']['min'] = $this->min ;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['options']['max'] = $this->max ;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['options']['step'] = $this->step ;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['options']['readOnly'] = $this->readOnly ;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['options']['colSpan'] = $this->colSpan ;
    if($generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['options']['readOnly'] === 'yes') {
      $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['options']['readOnly'] = 'yes' ;
    }
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['schemaFields'][$this->field] = $this->defaultValue;


    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['value'] = [] ;

                  for ($i=0; $i < $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['numberOflines'] ; $i++) { 
             
                    array_push($generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['value'],
                     $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['schemaFields']);
  
                }


   }


}