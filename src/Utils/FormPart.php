<?php

namespace Tassili\Prime\Utils;

use Illuminate\Support\Str;

class FormPart
{
   public function getForm($panel,$panelCamel,$formName,$modelParent,$modele) {
       return "<?php
namespace  App\Http\Controllers\Tassili\\{$panelCamel}\Crud\\{$modelParent}\Forms;     

use Illuminate\Http\Request;
use Tassili\Prime\Http\Resources\TassiliForm;
use App\Http\Controllers\Controller;
use Tassili\Prime\Fields\TextInput;
use Spatie\RouteAttributes\Attributes\Post;

class $formName
{

  public TassiliForm \$tassili;
  public \$model = '\App\Models\\$modele';

  public function __construct(TassiliForm \$tassili,Request \$request)
    {
        \$this->tassili  = \$tassili;
        \$this->register(\$request,[]);
    }

    public function register(\$request, array \$options) {

       \$this->tassili->addForm([
            'className' => '\App\Http\Controllers\Tassili\\$panelCamel\Crud\\$modelParent\Forms\\$formName' ,
            'action' => 'create',
            'permissions' => [] ,
        ])->form([
            TextInput::make('name')
        ]);

    }

     public function create(Request \$request)
    {
        \$this->tassili->checkPermissions(\$request);
        
        \$request->validate(['name' => ['required']]);

        \$this->tassili->record = new \$this->model ;

        \$this->tassili->createRecord(\$request);
        \$this->tassili->record->save();  
    }


   }

";


   }
}