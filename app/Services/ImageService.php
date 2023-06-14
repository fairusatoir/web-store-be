<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    protected $str;

    public function __construct(Str $str)
    {
        $this->str = $str;
    }

    /**
     * Store new image
     *
     * @param  mixed $request
     * @return String Directory the file is saved
     */
    public function store(Request $request): String
    {
        $file = $request->file('photo');

        $extension = $file->getClientOriginalExtension();
        $fileName = 'photo_product_' . $this->str->random(10) . '.' . $extension;
        $directory = 'assets/product/' . $request->products_id;

        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        $path = $file->storeAs($directory, $fileName, 'public');
        return $path;
    }
}
