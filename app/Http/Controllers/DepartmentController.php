<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

use Illuminate\Support\Facades\Validator;

use App\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        try {
            //$validated = Validator::make($request->all(), [
            //    'name' => 'required|unique:departments|max:255'
            //]);
//            $validated = $request->validated();

            //if($validated->fails()) return response()->json(['asd'=>23]);

            $department = new Department;
            $department->name = $request->name;
            $department->save();

            return response()->json([
                'id' => $department->id,
                'name' => $department->name,
                'code' => '200',
                'message' => 'Succes'
            ]);
        } catch(\Exception $exception){
            return response()->json([
                'message' => '',
                'code' => 400 
            ]);
        }
        



        /*
            Add new department
            If name of departments is not unque, response error
        */




    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
