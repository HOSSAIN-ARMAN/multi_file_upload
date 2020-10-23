<?php

namespace App\Http\Controllers;

use App\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UploadFileController extends Controller
{
    public function index () {
        return view('welcome', [
            'images' => UploadFile::latest()->get()
        ]);
    }
    public function show() {
        if (!is_dir(public_path('/images/'))){
            mkdir(public_path('/images/'), 0777);
        }

        $images = Collection::wrap(request()->file('file'));
        $images->each(function ($image) {
            $baseName = Str::random();
            $original = $baseName.'.'.$image->getClientOriginalExtension();
            $thumbnail = $baseName.'_thumb.'.$image->getClientOriginalExtension();
            Image::make($image)->fit(250, 250)->save(public_path('/images/').$thumbnail);
//            dd($thumbnail);
            $image->move(public_path('/images/'), $original);
            UploadFile::create([
                'original' => $original,
                'thumbnail' => $thumbnail
            ]);
        });


    }
    public function destroy (UploadFile $uploadFile) {
        File::delete([
           public_path('/images/'.$uploadFile->original),
           public_path('/images/'.$uploadFile->thumbnail)
        ]);
        $uploadFile->delete();
        return redirect('/');
    }
}
