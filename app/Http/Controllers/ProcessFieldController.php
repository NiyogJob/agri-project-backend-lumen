<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessFieldController extends Controller
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
        if (!$request->has('process_date')) {
            $res['success'] = false;
            $res['message'] = 'Add process failed! process date is required';
            return response($res, 400);
        }

        if (!$request->has('tractor_name')) {
            $res['success'] = false;
            $res['message'] = 'Add process failed! tractor name  is required';
            return response($res, 400);
        }

        if (!$request->has('list_cart')) {
            $res['success'] = false;
            $res['message'] = 'Add process failed! list item is required';
            return response($res, 400);
        }

        $tname = $request->tractor_name;
        $pdate = $request->process_date;
        $data = $request->list_cart;

        DB::beginTransaction();
        try {
            

            foreach ($data as $bb) {
                
                $fname = $bb['field_name'];
                $cname = $bb['culture_name'];
                $parea = $bb['process_area'];
                $tarea = $bb['crop_totalarea'];
                

                $data = DB::table("cropfielditem")->where("cropfield_name", $fname)->first();
                $difference_area=($data->crop_processedarea)-$parea;

                if($difference_area>0){
                
                DB::table("process_field")->insert([
                    'field_name' => $fname,
                    'culture_name' => $cname,
                    'process_area' => $parea,
                    'tractor_name' => $tname,
                    'process_date' => $pdate,
                ]);

                DB::table("cropfielditem")->where('cropfield_name', $fname)->update([
                    
                    'crop_processedarea' => $difference_area,
                    
     
                ]);
               }
            }

            DB::commit();
            $res['success'] = true;
            
            $res['message'] = "Successfully processed";
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

        $id = $request->process_id;
        try {
            $data = DB::table("process_field")->where("process_id", $id)->first();
            $res['success'] = true;
            $res['data'] = $data;
            $res['message'] = "get processed field report success";
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['success'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }
        
    

    public function delete(Request $request)
    {
        if (!$request->has('process_id')) {
            $res['success'] = false;
            $res['message'] = 'Delete field failed! ID is required';
            return response($res, 400);
        }

        $id = $request->process_id;
        DB::beginTransaction();
        try {
            DB::delete("DELETE FROM process_field WHERE process_id = ?", [$id]);
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
            $data = DB::table("process_field")->orderBy("process_id", "asc")->get();
            $res['success'] = true;
            $res['data'] = $data;
            $res['message'] = "get report success";
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
            $data = DB::table("process_field")->whereRaw("field_name LIKE ? or culture_name LIKE ? or culture_name LIKE ? or tractor_name LIKE ?", [$search,$search,$search,$search])->get();
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
