<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TractorsController extends Controller
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
        if (!$request->has('tractor_name') || $request->tractor_name == '') {
            $res['success'] = false;
            $res['message'] = 'Add tractor failed! name is required';
            return response($res, 400);
        }

        $name = $request->tractor_name;
        
        DB::beginTransaction();
        try {
            DB::table("tractors")->insert([
                'tractor_name' => $name,
                
            ]);

            DB::commit();
            $res['success'] = true;
            $res['message'] = "Add tractor success";
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
        if (!$request->has('tractor_id') || !$request->has('tractor_name') || $request->tractor_id == '' || $request->tractor_name == '') {
            $res['success'] = false;
            $res['message'] = 'Edit tractor failed! ID and name is required';
            return response($res, 400);
        }

        $id = $request->tractor_id;
        $name = $request->tractor_name;
        

        DB::beginTransaction();
        try {
            DB::table("tractors")->where('tractor_id', $id)->update([
                'tractor_name' => $name,
                

            ]);
            DB::commit();
            $res['success'] = true;
            $res['message'] = "Edit tractor success";
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
        $id = $request->tractor_id;
        try {
            $data = DB::table("tractors")->where("tractor_id", $id)->first();
            $res['success'] = true;
            $res['data'] = $data;
            $res['message'] = "get tractor success";
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['success'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }

    public function delete(Request $request)
    {
        if (!$request->has('tractor_id')) {
            $res['success'] = false;
            $res['message'] = 'Delete tractor failed! ID is required';
            return response($res, 400);
        }

        $id = $request->tractor_id;
        DB::beginTransaction();
        try {
            $_reg = DB::delete("DELETE FROM tractors WHERE tractor_id = ?", [$id]);
            DB::commit();
            $res['success'] = true;
            $res['message'] = "Delete tractor success";
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
            $data = DB::table("tractors")->orderBy("tractor_name", "asc")->get();
            $res['success'] = true;
            $res['data'] = $data;
            $res['message'] = "get list tractor success";
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
            $data = DB::table("tractors")->whereRaw("tractor_name LIKE ?", [$search])->get();
            $res['success'] = true;
            $res['data'] = $data;
            $res['message'] = "search tractor success";
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['success'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }
}
