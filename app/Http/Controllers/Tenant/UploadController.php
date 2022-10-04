<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UploadController extends Controller
{

    public function uploadview(Request $request)
    {
        $files = Storage::disk('public')->files('uploads/');

        $files = collect($files)->map(function($file) {
            return Storage::url($file);
        })->toArray();

        return view('tenant.upload.index', ['files' => $files]);
    }


    public function upload(Request $request)
    {
        $file = $request->file('image');

        $extension = $file->getClientOriginalExtension();
        $new_file_name = now()->timestamp .'.'. $extension;


        $destinationPath = '/uploads/' ;


       

        $file->storePubliclyAs($destinationPath,$new_file_name,['disk' => 'public']);
     

        return back()->with('success',"file uploaded!");
    }




}
