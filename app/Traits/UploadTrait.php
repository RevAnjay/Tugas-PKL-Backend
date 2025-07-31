<?php

namespace App\Traits;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Storage;

trait UploadTrait
{

    public function exist(string $file)
    {
        return Storage::exists($file);
    }

    public function upload(string $path, UploadedFile $file, bool $useOriginalName = false)
    {
        if(!$this->exist($path)) Storage::makeDirectory($path);

        if ($useOriginalName) return $file->storeAs($path, $file->getClientOriginalName());

        return $file->storeAs($path, $file->hashName());
    }

    public function remove(string $file)
    {
        if($this->exist($file)) Storage::delete($file);
    }
}
