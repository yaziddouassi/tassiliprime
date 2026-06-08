<?php
namespace Tassili\Prime\Fields;

class MultipleFile
{
    protected string $field;
    protected string $type = 'MultipleFile';
    protected $defaultValue = [];
    protected $label = '';
    protected $noDatabase = 'no';
    protected $nullable = 'no';
    protected $noTouchable = 'no';
    protected $readOnly = 'no';
    protected $maxNumberFiles = 1000000000000;
    protected string $folder;
    protected $colSpan = ['sm' =>  1 , 'md' => 1 , 'lg' => 1 , 'xl' => 1];

    public static function make(string $field): self
    {
        $instance = new self();
        $instance->field = $field;
        $instance->folder = config('tassili.storage_folder');
        $instance->label = ucfirst($field);
        return $instance;
    }

    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

     public function folder(string $folder): self
    {
        $this->folder = $folder;
        return $this;
    }

      public function readOnly(): self
    {
        $this->readOnly = 'yes';
        return $this;
    }
   
    public function notInDatabase(): self
    {
        $this->noDatabase = 'yes';
        return $this;
    }

    public function fieldAndRecordNotNull(): self
    {
        $this->nullable = 'yes';
        return $this;
    }

     public function keepExistingFiles(): self
    {
        $this->noTouchable = 'yes';
        return $this;
    }

    public function maxNumberFiles(int $maxNumberFiles): self
    {
        $this->maxNumberFiles = $maxNumberFiles;
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
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['type'] = 'MultipleFile';
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['value'] = $this->defaultValue;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['label'] = $this->label;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['defaultValue'] = $this->defaultValue;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['noDatabase'] = $this->noDatabase;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['tempUrlTabs'] = [];
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['existingFiles'] = [];
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['nullable'] = $this->nullable;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['noTouchable'] = $this->noTouchable;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['readOnly'] = $this->readOnly;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['maxNumberFiles'] = $this->maxNumberFiles;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['storage_folder'] = $this->folder;
        $generator->tassiliFormList[$generator->customActionUrlTemoin]['fields'][$this->field]['options']['colSpan'] = $this->colSpan;
    }   


}