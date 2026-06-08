<?php
namespace Tassili\Prime\Fields;

class Hidden
{
    protected string $field;
    protected string $type = 'Hidden';
    protected $defaultValue = '';
    protected $noDatabase = 'no';
    protected $colSpan = ['sm' =>  1 , 'md' => 1 , 'lg' => 1 , 'xl' => 1];
    
    public static function make(string $field): self
    {
        $instance = new self();
        $instance->field = $field;
        return $instance;
    }

    public function value($value): self
    {
        $this->defaultValue = $value;
        return $this;
    }

    
    public function notInDatabase(): self
    {
        $this->noDatabase = 'yes';
        return $this;
    }

     public function registerToCustomAction($generator): void
    {

        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['field'] = $this->field;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['type'] = $this->type;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['value'] = $this->defaultValue;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['defaultValue'] = $this->defaultValue;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['noDatabase'] = $this->noDatabase;
    }   


    public function repeteurToCustomAction($generator , $field) {
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['field'] = $this->field;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['type'] = $this->type;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['value'] = $this->defaultValue;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['options']['defaultValue'] = $this->defaultValue ;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['fields'][$this->field]['options']['noDatabase'] = $this->noDatabase ;
    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['schemaFields'][$this->field] = $this->defaultValue;


    $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['value'] = [] ;

                  for ($i=0; $i < $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['numberOflines'] ; $i++) { 
             
                    array_push($generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['value'],
                     $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$field]['schemaFields']);
  
                }

   }

}