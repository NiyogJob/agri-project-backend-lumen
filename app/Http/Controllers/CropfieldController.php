<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CropfieldController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function add(Request $request)
    {
        if (!$request->has('cropfield_name') || $request->cropfield_name == '') {
            $res['success'] = false;
            $res['message'] = 'add cropfield failed! crop field name is required';
            return response($res, 400);
        }

        if (!$request->has('crop_name') || $request->crop_name == '') {
            $res['success'] = false;
            $res['message'] = 'add cropfield failed! crop name is required';
            return response($res, 400);
        }

        if (!$request->has('crop_totalarea') || $request->crop_totalarea == '') {
            $res['success'] = false;
            $res['message'] = 'add cropfield failed! crop total area is required';
            return response($res, 400);
            
        }

        if (!$request->has('crop_processedarea') || $request->crop_processedarea == ''|| $request->crop_processedarea == 0) {
            $res['success'] = false;
            $res['message'] = 'add cropfield failed! crop area value invalid';
        }

        $cropfield_name = $request->cropfield_name;
        $crop_name = $request->crop_name;
        $crop_totalarea = $request->crop_totalarea;
        $crop_processedarea = $request->crop_totalarea;
        DB::beginTransaction();
        try {
            DB::table("cropfielditem")->insert([
                'cropfield_name' => $cropfield_name,
                'crop_name' => $crop_name,
                'crop_totalarea' => $crop_totalarea,
                'crop_processedarea' => $crop_processedarea,
            ]);

            DB::commit();
            $res['success'] = true;
            $res['message'] = "Add cropfield item success";
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $res['success'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }

    public function edit(Request $request)
    {
         if (!$request->has('cropfield_name') || $request->cropfield_name == '') {
            $res['success'] = false;
            $res['message'] = 'edit failed! crop field name is required';
            return response($res, 400);
        }

        if (!$request->has('crop_name') || $request->crop_name == '') {
            $res['success'] = false;
            $res['message'] = 'edit failed! crop name is required';
            return response($res, 400);
        }

        if (!$request->has('crop_totalarea') || $request->crop_totalarea == '') {
            $res['success'] = false;
            $res['message'] = 'edit failed! crop total area is required';
            return response($res, 400);
            
        }

        if (!$request->has('crop_processedarea') || $request->crop_processedarea == '') {
           
        }

        $cropfield_name = $request->cropfield_name;
        $crop_name = $request->crop_name;
        $crop_totalarea = $request->crop_totalarea;
        

        DB::beginTransaction();
        try {
            DB::table("cropfielditem")->where('cropfield_name', $cropfield_name)->update([
                
                'crop_name' => $crop_name,
                'crop_totalarea' => $crop_totalarea,
                
 
            ]);
            DB::commit();
            $res['success'] = true;
            $res['message'] = "Edit cropfield success";
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $res['success'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }

    public function get(Request $request)
    {
        $name = $request->cropfield_name;
        try {
            $data = DB::table("cropfielditem")->where("cropfield_name", $name)->first();
            $res['success'] = true;
            $res['data'] = $data;
            $res['message'] = "get item success";
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['success'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }

    public function delete(Request $request)
    {
        if (!$request->has('cropfield_name')) {
            $res['success'] = false;
            $res['message'] = 'Delete item failed! cropfield_name is required';
            return response($res, 400);
        }

        $name = $request->cropfield_name;
        DB::beginTransaction();
        try {
            DB::delete("DELETE FROM cropfielditem WHERE cropfield_name = ?", [$name]);
            DB::commit();
            $res['success'] = true;
            $res['message'] = "Delete item success";
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $res['success'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }

    function list(Request $request) {
        try {
            $data = DB::table("cropfielditem")->orderBy("cropfield_name", "asc")->get();
            $res['success'] = true;
            $res['data'] = $data;
            $res['message'] = "get list item success";
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['success'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }
    public function search(Request $request)
    {
        $search = "%" . $request->search_keyword . "%";
        try {
            $data = DB::table("cropfielditem")->whereRaw("crop_name LIKE ?", [$search])->get();
            $res['success'] = true;
            $res['data'] = $data;
            $res['message'] = "search item success";
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['success'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }
}
