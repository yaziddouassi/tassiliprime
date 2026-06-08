<?php
namespace Tassili\Prime\Fields;

class Signature
{
    protected string $field;
    protected string $type = 'Signature';
    protected $defaultValue = '';
    protected $label = '';
    protected $noDatabase = 'no';
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
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['readOnly'] = $this->readOnly;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['colSpan'] = $this->colSpan;
    }   

}