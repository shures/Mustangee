<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Array_;

class ContentController extends Controller
{
    public function add_location(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => "required|array|min:3|max:12",
            'images.*' => "image|mimes:jpeg,png,jpg|max:15000",
            'image_titles' => "array|min:3|max:12",
            'image_titles.*' => "nullable|string|min:8|max:200",
            'Timages' => "required|array|min:3|max:12",
            'Timages.*' => "image|mimes:jpeg,png,jpg|max:5000",
            'name' => 'nullable|string|min:8|max:500',
            'title' => 'nullable|string|min:8|max:500',
            'elevation' => 'nullable|string|min:8|max:500',
            'route'=> 'nullable|string|min:8|max:500',
            'distance'=> 'nullable|string|min:8|max:500',
            'famouse_for'=> 'nullable|string|min:8|max:800',
            'about'=> 'nullable|string|min:8|max:1000',
       ]);
        if ($validator->fails()) {
            $errors = array('errors',$validator->errors());
            return response()->json($errors);
        } else {
            if(count($_FILES["images"]["name"])!=count($_FILES["Timages"]["name"])){
                $errors = array('errors',"No of images and thumbnails are not matching !");
                return response()->json($errors);
            }
            $location_id = DB::table('locations')->insertGetId(['name'=>$request->name,'title'=>$request->title,'elevation'=>$request->elevation,'route'=>$request->route,'distance'=>$request->distance,'famous_for'=>$request->famous_for,'about'=>$request->about]);
            if($location_id) {
                $target_dir_thumbnail = FILE_ROOT . '/location/thumbnail/';
                $target_dir_images = FILE_ROOT . '/location/images/';
                for ($i = 0; $i < count($_FILES["Timages"]["name"]); $i++) {
                    $target_file = $target_dir_thumbnail . basename($_FILES["Timages"]["name"][$i]);
                    move_uploaded_file($_FILES["Timages"]["tmp_name"][$i], $target_file);

                    $target_file = $target_dir_images . basename($_FILES["images"]["name"][$i]);
                    if (move_uploaded_file($_FILES["images"]["tmp_name"][$i], $target_file)) {
                        $query = DB::table('location_images')->insert(['name'=>$_FILES["images"]["name"][$i],'location_id'=>$location_id,'title'=>$request->image_titles[$i]]);
                    }
                }
            }
        }
    }
}
