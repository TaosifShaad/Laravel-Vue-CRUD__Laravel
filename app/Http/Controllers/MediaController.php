<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;

class MediaController extends Controller
{
    /*public function upload(Request $request) {

        // $request->validate([
        //     'file' => 'required|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf'
        // ]);
        dd($request->file('file')->getClientOriginalName());

        $media = new Media;
        if ($request->file()) {
            $file_name = $request->file->getClientOriginalName();
            $file_path = $request->file('file')->storePubliclyAs('uploads', $file_name);
            return public_path($file_path);
            // $image = $request->file('image');
            // $new_name = rand().'.'.$image->getClientOriginalExtension();
            // $path = asset('images/').$new_name;

            $media->name = time().'_'.$request->file->getClientOriginalName();
            $media->path = '/storage/'.$file_path;
            $media->save();
            // return $path;
            return asset($media->path);
            return response()->json(['success'=>'file uploaded successfully.']);
        }
    }*/

    public function upload(Request $request) {
        // dd($request->file('file')->getClientOriginalName());
        $image = $request->file;
        $name = $image->getClientOriginalName();
        $image->storeAs('public/images', $name);
        // $image_save = new Media;

        // $image_save->name = $name;
        // $path = asset('images/').$name;
        // $image_save->path = '/storage/'.$path;
        // $image_save->save();
        return response()->json(['success'=>'file uploaded successfully.']);
    }
}
