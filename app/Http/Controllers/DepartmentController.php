<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

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
        $department = new Department;
        $department->fill($request->validated())->save();

        return response()->json([
            'id' => $department->id,
            'name' => $department->name,
            'code' => '200',
            'message' => 'Entry added successfully'
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, $id)
    {
        try {
            $department = Department::findOrFail($id);


            $department->fill($request->all())->save();

            return response()->json([
                'id' => $department->id,
                'name' => $department->name,
                'code' => '200',
                'message' => 'Entry updated successfully'
            ]);

        } catch(\Exception $e){
            return response()->json([
                'messsage' => $e->getMessage(),
            ]);

        }

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
