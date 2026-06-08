<?php

namespace Tassili\Prime\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TassiliForm2
{
    public array $tassiliSettings = [];
    public array $tassiliFormList = [];
    public $record = null;

    public $collections = [] ;
    public $bulkActifs = [] ;
    public $bulks = [] ;
    public $bulkTabs = [] ;
    public $bulkOpens = [] ;
    public $modalFormList = [] ;

    public string $customActionUrlTemoin = '';

    private array $arrayTypes1 = ['Text', 'Date', 'Number', 'Hidden', 'Select', 'Radio', 'Textarea', 'Signature'];
    private array $arrayTypes2 = ['Quill'];
    private array $arrayTypes4 = ['File','FileEdit'];
    private array $arrayTypes5 = ['MultipleFile','MultipleFileEdit'];
    private array $arrayTypes6 = ['CheckboxList'];
    private array $arrayTypes7 = ['Checkbox'];
    private array $arrayTypes8 = ['Password'];
    private array $arrayTypes9 = ['Repeater'];

    public function __construct(array $settings = [])
    {
        config(['inertia.ssr.enabled' => false]);
        $this->tassiliSettings = array_merge($this->tassiliSettings, $settings);

    }

     public function addForm(array $settings): self
    {
        $this->tassiliFormList[$settings['url']]['info'] = $settings;
        $this->tassiliFormList[$settings['url']]['info']['modalWidth'] = '580px';
        $this->tassiliFormList[$settings['url']]['info']['grid'] = ['sm' =>  1 , 'md' => 1 , 'lg' => 1 , 'xl' => 1];
        $this->tassiliFormList[$settings['url']]['info']['wizardActive'] = 'no';
        $this->tassiliFormList[$settings['url']]['info']['wizard'] = [];
        $this->tassiliFormList[$settings['url']]['info']['wizardCurrent'] = 1;

        $this->tassiliFormList[$settings['url']]['info']['createOther'] = 'yes';
        $this->tassiliFormList[$settings['url']]['info']['updateAndStay'] = 'no';
        $this->tassiliFormList[$settings['url']]['info']['createLabel'] = 'Create';
        $this->tassiliFormList[$settings['url']]['info']['createOtherLabel'] = 'CreateOther';
        $this->tassiliFormList[$settings['url']]['info']['updateLabel'] = 'Update';
        $this->tassiliFormList[$settings['url']]['info']['updateAndStayLabel'] = 'Update And Stay';
        $this->tassiliFormList[$settings['url']]['info']['routeSession'] = '';
        $this->tassiliFormList[$settings['url']]['info']['routeSessionData'] = [];
        $this->tassiliFormList[$settings['url']]['info']['route'] = '';
        $this->tassiliFormList[$settings['url']]['info']['isAnimated'] = 'off'; 
        $this->tassiliFormList[$settings['url']]['info']['createMessage'] = 'Record created'; 
        $this->tassiliFormList[$settings['url']]['info']['updateMessage'] = 'Record updated';
        $this->customActionUrlTemoin = $settings['url'];
        
        return $this;
    }

     public function collectionFormInsert(array $settings): self {
        $this->addForm($settings) ;
        $this->collections[$settings['collection']]['urlCreation'] = $settings['url'];
        $this->bulkActifs[$settings['collection']][0] = 'yes';
        return $this;
    }

     public function collectionForm(array $settings): self
    {
        $this->bulkActifs[$settings['collection']][2] = 'yes';
        $this->modalFormList[$settings['collection']][$settings['url']] = $settings['url'] ;
        $this->tassiliFormList[$settings['url']]['info'] = $settings;
        $this->tassiliFormList[$settings['url']]['info']['modalWidth'] = '580px';
        $this->tassiliFormList[$settings['url']]['info']['grid'] = ['sm' =>  1 , 'md' => 1 , 'lg' => 1 , 'xl' => 1];
        $this->tassiliFormList[$settings['url']]['info']['wizardActive'] = 'no';
        $this->tassiliFormList[$settings['url']]['info']['wizard'] = [];
        $this->tassiliFormList[$settings['url']]['info']['wizardCurrent'] = 1;

        $this->tassiliFormList[$settings['url']]['info']['createOther'] = 'yes';
        $this->tassiliFormList[$settings['url']]['info']['updateAndStay'] = 'no';
        $this->tassiliFormList[$settings['url']]['info']['createLabel'] = 'Create';
        $this->tassiliFormList[$settings['url']]['info']['createOtherLabel'] = 'CreateOther';
        $this->tassiliFormList[$settings['url']]['info']['updateLabel'] = 'Update';
        $this->tassiliFormList[$settings['url']]['info']['updateAndStayLabel'] = 'Update And Stay';
        $this->tassiliFormList[$settings['url']]['info']['routeSession'] = '';
        $this->tassiliFormList[$settings['url']]['info']['routeSessionData'] = [];
        $this->tassiliFormList[$settings['url']]['info']['route'] = '';
        $this->tassiliFormList[$settings['url']]['info']['isAnimated'] = 'off';
        $this->tassiliFormList[$settings['url']]['info']['createMessage'] = 'Record created'; 
        $this->tassiliFormList[$settings['url']]['info']['updateMessage'] = 'Record updated';
        $this->customActionUrlTemoin = $settings['url'];
        
        return $this;
    }

    public function grid(array $grid) {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['grid'] = $grid;
         return $this;
    }

    public function hideCreateOther() {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['createOther'] = 'no';
         return $this;
    }

    public function showUpdateAndStay() {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['updateAndStay'] = 'yes';
         return $this;
    }

     public function LabelButtonCreate($createLabel) {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['createLabel'] = $createLabel;
         return $this;
    }

    public function LabelButtonCreateOther($createOtherLabel) {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['createOtherLabel'] = $createOtherLabel;
         return $this;
    }

    public function LabelButtonUpdate($updateLabel) {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['updateLabel'] = $updateLabel;
        return $this;
    }

    public function LabelButtonUpdateAndStay($updateLabelAndStay) {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['updateAndStayLabel'] = $updateLabelAndStay;
         return $this; 
    }

    public function redirectToList($panel,$model) {
        $transformString = new \Tassili\Prime\Utils\TransformString();
        $url =  $transformString->transformUrl($model);
        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['routeSession'] = 'active';
        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['routeSessionData']['panel'] = $panel;
        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['routeSessionData']['model'] = $model;
        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['routeSessionData']['url'] = $url;
         return $this;
    }
                    
    public function redirectToUrl($route) {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['route'] = $route;
        return $this;
    } 

    public function LabelCreateMessage($createMessage) {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['createMessage'] = $createMessage;
         return $this;
    }

    public function LabelUpdateMessage($updateMessage) {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['updateMessage'] = $updateMessage;
         return $this;
    }


    public function form(array $fields): self
    {
        foreach ($fields as $field) {
            $field->registerToCustomAction($this);
        }
        
        return $this;
    }

      public function addCollection(array $options): void
    {
         if (isset($options['records']) && is_callable($options['records'])) {
               $options['records'] = ($options['records'])();
             }

        $this->collections[$options['collection']] = $options;
        $this->collections[$options['collection']]['urlCreation'] = ''; 
        $this->bulkActifs[$options['collection']] = ['no','no','no'];
    }

    public function collectionBulk(array $options): void
    {
        $this->bulks[$options['collection']][$options['url']] = $options;
        $this->bulkTabs[$options['collection']] = [];
        $this->bulkActifs[$options['collection']][1] = 'yes';
        $this->bulkOpens[$options['collection']] = 'no';
    }

    public function wizard(array $wizard): self
    {
        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['wizard'] = $wizard;
        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['wizardActive'] = 'yes';
        
        return $this;
    }
   
     public function updateRecord(Request $request): void
    {
        $url = $request->urlValidationurlValidationurlValidationTassili17485RRY4R4RD9448RK48K4RFRFIRU;

        foreach ($request->all() as $key => $value) {
            if (!array_key_exists($key, $this->tassiliFormList[$url]['fields'])) {
                continue;
            }

            $field = $this->tassiliFormList[$url]['fields'][$key];
            
            if (!$field || $field['options']['noDatabase'] === 'yes') {
                continue;
            }

            $this->processFieldValue($key, $value, $field, $request);
        }
    }

    public function createRecord(Request $request): void {
       $this->updateRecord($request);
    }

    private function processFieldValue(string $key, $value, array $field, Request $request): void
    {
        $type = $field['type'];

        if (in_array($type, array_merge($this->arrayTypes1, $this->arrayTypes2))) {
            $this->record[$key] = $value;
        }
        elseif (in_array($type, $this->arrayTypes6)) {
            $this->record[$key] = is_array($value) 
                ? json_encode($value) 
                : json_encode(explode(',', $value));
        }
        elseif (in_array($type, $this->arrayTypes7)) {
            $this->record[$key] = $value === 'true';
        }
        elseif (in_array($type, $this->arrayTypes8)) {
            if ($value) {
                $this->record[$key] = Hash::make($value);
            }
        }
        elseif (in_array($type, $this->arrayTypes9)) {
            $this->processRepeaterField($key, $value, $field);
        }
        elseif (in_array($type, $this->arrayTypes4)) {
            $this->processFileField($key, $field, $request);
        }
        elseif (in_array($type, $this->arrayTypes5)) {
            $this->processMultipleFileField($key, $value, $field, $request);
        }
    }

    private function processRepeaterField(string $key, $value, array $field): void
    {
        $cleanedRepeater = [];
        $allowedTypes = ['Text', 'Date', 'Number', 'Hidden', 'Select', 'Radio', 'Textarea', 'Quill', 'Checkbox'];

        foreach ($value as $repeaterItem) {
            $cleanedItem = [];

            foreach ($repeaterItem as $subKey => $subValue) {
                $subType = $field['fields'][$subKey]['type'] ?? null;

                if ($subType === 'CheckboxList') {
                    $cleanedItem[$subKey] = is_array($subValue) 
                        ? $subValue 
                        : explode(',', $subValue);
                }
                elseif (in_array($subType, $allowedTypes)) {
                    $cleanedItem[$subKey] = $subValue ?? '';
                }
            }

            $cleanedRepeater[] = $cleanedItem;
        }

        $this->record[$key] = json_encode($cleanedRepeater);
    }

    private function processFileField(string $key, array $field, Request $request): void
    {
        if (!$request->hasFile($key)) {
            return;
        }

        $dossier = $field['options']['storage_folder'];
        $dossierStorage = 'uploads/' . $dossier;
        $file = $request->file($key);
        $uniqueName = Str::uuid() . '.' . $file->getClientOriginalName();
        $file->storeAs($dossierStorage, $uniqueName, config('tassili.storage_disk'));
        $this->record[$key] = $dossierStorage . '/' . $uniqueName;
    }

    

    private function processMultipleFileField(string $key, $value, array $field, Request $request): void
    {
        $tab1 = json_decode($request->input($key . '_newtab'), true) ?? [];
        $dossier = $field['options']['storage_folder'];
        $dossierStorage = 'uploads/' . $dossier;

        if ($value) {
            foreach ($value as $file) {
                $uniqueName = Str::uuid() . '.' . $file->getClientOriginalName();
                $path = $file->storeAs($dossierStorage, $uniqueName, config('tassili.storage_disk'));
                $tab1[] = $path;
            }
        }

        $this->record[$key] = json_encode($tab1);
    }

    
    public function getInertiaData(): array
    {
        return [
            'user' => \Illuminate\Support\Facades\Auth::user(),
            'routes' => \Tassili\Prime\Models\TassiliCrud::where('active', true)
                     ->where('panel',$this->tassiliSettings['tassiliPanel'])->get(),
            'tassiliPanel' => $this->tassiliSettings['tassiliPanel'],
            'tassiliUrlStorage' => config('tassili.storage_url'),
            'tassiliFormList' => $this->tassiliFormList,
            'bulkActifs'  => $this->bulkActifs,
            'bulks' => $this->bulks ,
            'bulkTabs' => $this->bulkTabs ,
            'bulkOpens' => $this->bulkOpens ,
            'modalFormList' => $this->modalFormList ,
            'collections' => $this->collections ,
        ];
    }


}