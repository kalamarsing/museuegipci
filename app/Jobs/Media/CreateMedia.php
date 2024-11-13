<?php

namespace App\Jobs\Media;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use App\Tasks\BuildImageCrops;
use Storage;
use Illuminate\Support\Str;

class CreateMedia
{
    private $filePath = null;
    private $metadata = null;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public static function fromRequest(Request $request)
    {
        return new self($request->file('file'));
    }

    private function getFileMimeType()
    {
        return $this->file->getMimeType();
    }

    private function getFileType()
    {
        return explode('/', $this->getFileMimeType())[0] ?: null;
    }

    private function processImage()
    {
        //it  must  alsework with imfo from base65 decode
      //  $fileName = Str::random(10) . '.' . $this->file->getClientOriginalExtension();
        $fileName = pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . Str::random(10) . '.' . $this->file->getClientOriginalExtension();


        $path = $this->file->storeAs('medias/original', $fileName, 'public');

        if ($path) {
            // Build cropped images
            //OLD  (new BuildImageCrops(storage_path().'/app/'.$this->filePath))->run();


            (new BuildImageCrops($path, $this->file))->run();    
        
            // Devuelve la URL completa del archivo
            return [ 
              //  'url' => str_replace('original','thumbnail',Storage::url($path)),
                'url' => Storage::url($path),
                'filename' =>  $fileName
            ];
            
    
        }
        
        return false;
    }

    private function processFile()
    {
       // $fileName = Str::random(10) . '.' . $this->file->getClientOriginalExtension();
        $fileName = pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . Str::random(10) . '.' . $this->file->getClientOriginalExtension();

        $path = $this->file->storeAs('files', $fileName, 'public');

        if ($path){
            // Devuelve la URL completa del archivo
            return [ 
                'url' => Storage::url($path),
                'filename' =>  $fileName
            ];
        }


        return false;
    }

    public function handle()
    {
        switch ($this->getFileType()) {
            case 'image':
                $data = $this->processImage();

            break;

            default:
                $data = $this->processFile();

            break;
        }

     
        return $data;
    }
}
