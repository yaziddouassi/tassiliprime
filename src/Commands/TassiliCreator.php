<?php

namespace  Tassili\Prime\Commands;

use Illuminate\Console\Command;
use App\Models\User; // Ensure you import the User model
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class TassiliCreator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tassili:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the package';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////



         $path = resource_path('js/vendor');

         $sourcePath1 = base_path('vendor/tassili/prime/Fichiers/RouteFiles/tassili.php');

         $destinationPath1 = base_path('routes/tassili.php');

         if (File::exists($destinationPath1)) {
                 $this->error("Package already installed");
                 return Command::FAILURE;
            }

         if (!File::exists($path)) {
             File::makeDirectory($path, 0755, true);
         }

          if (File::exists($sourcePath1)) {
                File::copy($sourcePath1, $destinationPath1); // Crée destination.txt s'il n'existe pas
            }


        $filePath = base_path('routes/web.php');
            $content = file_get_contents($filePath);

                if (!str_contains($content, "require __DIR__.'/tassili.php';")) {
                     $linesToAdd = <<<PHP

                      require __DIR__.'/tassili.php';

                      PHP;

             file_put_contents($filePath, $linesToAdd, FILE_APPEND);
             }


         ///////////////////////////////////////////////////////////////////////////////////////////////////////
         //////////////////////////////////////////////////////////////////////////////////////////////////////
            $sourcePath4 = base_path('vendor/tassili/prime/Fichiers/TassiliLibs1');
       
            $temp4 = 'resources/js/vendor/TassiliLibs'  ;
    
            $directory4 = base_path($temp4);
    
            File::copyDirectory($sourcePath4, $directory4);
    
            if (!File::exists($directory4)) {
                return response()->json(['error' => 'Dossier non trouvé.'], 404);
            }
        
            // Récupère tous les fichiers (même dans les sous-dossiers)
            $files4 = File::allFiles($directory4);
        
            foreach ($files4 as $file4) {
                if ($file4->getExtension() === 'txt') {
                    // Nouveau nom avec extension .vue
                    $newFileName4 = str_replace('.txt', '.vue', $file4->getFilename());
        
                    // Nouveau chemin complet
                    $newFilePath4 = $file4->getPath() . '/' . $newFileName4;
        
                    // Renommer le fichier
                    File::move($file4->getPathname(), $newFilePath4);
                }
            }


        ///////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////


         $sourcePath5 = base_path('vendor/tassili/prime/Fichiers/TassiliDev1');
       
            $temp5 = 'resources/js/Pages/TassiliDev'  ;
    
            $directory5 = base_path($temp5);
    
            File::copyDirectory($sourcePath5, $directory5);
    
            if (!File::exists($directory5)) {
                return response()->json(['error' => 'Dossier non trouvé.'], 404);
            }
        
            // Récupère tous les fichiers (même dans les sous-dossiers)
            $files5 = File::allFiles($directory5);
        
            foreach ($files5 as $file5) {
                if ($file5->getExtension() === 'txt') {
                    // Nouveau nom avec extension .vue
                    $newFileName5 = str_replace('.txt', '.vue', $file5->getFilename());
        
                    // Nouveau chemin complet
                    $newFilePath5 = $file5->getPath() . '/' . $newFileName5;
        
                    // Renommer le fichier
                    File::move($file5->getPathname(), $newFilePath5);
                }
            }

            /////////////////////////////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////////////////


         

         $sourcePath6 = base_path('vendor/tassili/prime/Fichiers/MiddlewareFiles/TassiliAuth.php');
         $destinationPath6 = base_path('app/Http/Middleware/TassiliAuth.php');

         File::copy($sourcePath6, $destinationPath6);


         $this->info("✅ Package Tassili Pro installed!");


    }
}