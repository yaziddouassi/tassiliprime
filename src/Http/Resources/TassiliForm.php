<?php

namespace Tassili\Prime\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TassiliForm
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
       
        $url = $settings['className'] . '-fonction-' .  $settings['action'];

        $this->tassiliFormList[$url]['info'] = $settings;
        $this->tassiliFormList[$url]['info']['modalWidth'] = '580px';
        $this->tassiliFormList[$url]['info']['grid'] = ['sm' =>  1 , 'md' => 1 , 'lg' => 1 , 'xl' => 1];
        $this->tassiliFormList[$url]['info']['wizardActive'] = 'no';
        $this->tassiliFormList[$url]['info']['wizard'] = [];
        $this->tassiliFormList[$url]['info']['wizardCurrent'] = 1;

        $this->tassiliFormList[$url]['info']['createOther'] = 'yes';
        $this->tassiliFormList[$url]['info']['updateAndStay'] = 'no';
        $this->tassiliFormList[$url]['info']['createLabel'] = 'Create';
        $this->tassiliFormList[$url]['info']['createOtherLabel'] = 'CreateOther';
        $this->tassiliFormList[$url]['info']['updateLabel'] = 'Update';
        $this->tassiliFormList[$url]['info']['updateAndStayLabel'] = 'Update And Stay';
        $this->tassiliFormList[$url]['info']['routeSession'] = '';
        
        $this->tassiliFormList[$url]['info']['routeSessionData'] = [];
        $this->tassiliFormList[$url]['info']['route'] = '';
        $this->tassiliFormList[$url]['info']['isAnimated'] = 'off'; 
        $this->tassiliFormList[$url]['info']['createMessage'] = 'Record created'; 
        $this->tassiliFormList[$url]['info']['updateMessage'] = 'Record updated';
        $this->customActionUrlTemoin = $url ;
        
        return $this;
    }

     public function collectionFormInsert(array $settings): self {
        $url = $settings['className'] . '-fonction-' .  $settings['action'];
        $this->addForm($settings) ;
        $this->collections[$settings['collection']]['urlCreation'] = $url;
        $this->bulkActifs[$settings['collection']][0] = 'yes';
        return $this;
    }

     public function collectionForm(array $settings): self
    {

        $url = $settings['className'] . '-fonction-' .  $settings['action'];
       
        $this->bulkActifs[$settings['collection']][2] = 'yes';
        $this->modalFormList[$settings['collection']][$url] = $url ;
        $this->tassiliFormList[$url]['info'] = $settings;
        $this->tassiliFormList[$url]['info']['modalWidth'] = '580px';
        $this->tassiliFormList[$url]['info']['grid'] = ['sm' =>  1 , 'md' => 1 , 'lg' => 1 , 'xl' => 1];
        $this->tassiliFormList[$url]['info']['wizardActive'] = 'no';
        $this->tassiliFormList[$url]['info']['wizard'] = [];
        $this->tassiliFormList[$url]['info']['wizardCurrent'] = 1;

        $this->tassiliFormList[$url]['info']['createOther'] = 'yes';
        $this->tassiliFormList[$url]['info']['updateAndStay'] = 'no';
        $this->tassiliFormList[$url]['info']['createLabel'] = 'Create';
        $this->tassiliFormList[$url]['info']['createOtherLabel'] = 'CreateOther';
        $this->tassiliFormList[$url]['info']['updateLabel'] = 'Update';
        $this->tassiliFormList[$url]['info']['updateAndStayLabel'] = 'Update And Stay';
        $this->tassiliFormList[$url]['info']['routeSession'] = '';
        $this->tassiliFormList[$url]['info']['routeSessionData'] = [];
        $this->tassiliFormList[$url]['info']['route'] = '';
        $this->tassiliFormList[$url]['info']['isAnimated'] = 'off';
        $this->tassiliFormList[$url]['info']['createMessage'] = 'Record created'; 
        $this->tassiliFormList[$url]['info']['updateMessage'] = 'Record updated';
        $this->customActionUrlTemoin = $url;
        
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

     public function labelButtonCreate($createLabel) {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['createLabel'] = $createLabel;
         return $this;
    }

    public function labelButtonCreateOther($createOtherLabel) {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['createOtherLabel'] = $createOtherLabel;
         return $this;
    }

    public function labelButtonUpdate($updateLabel) {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['updateLabel'] = $updateLabel;
        return $this;
    }

    public function labelButtonUpdateAndStay($updateLabelAndStay) {

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

    public function labelCreateMessage($createMessage) {

        $this->tassiliFormList[$this->customActionUrlTemoin]['info']['createMessage'] = $createMessage;
         return $this;
    }

    public function labelUpdateMessage($updateMessage) {

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
        $url = $options['className'] . '-fonction-' .  $options['action'];
        $options['urlDelete'] = $url;
        $this->collections[$options['collection']] = $options;
        $this->collections[$options['collection']]['urlCreation'] = ''; 
        $this->bulkActifs[$options['collection']] = ['no','no','no'];
    }

    public function collectionBulk(array $options): void
    {
        $url = $options['className'] . '-fonction-' .  $options['action'];
        $options['url'] = $url;
        $this->bulks[$options['collection']][$url] = $options;
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
            'permissions' => auth()->user()
                      ->getAllPermissions()
                      ->pluck('name'),
        ];
    }


}