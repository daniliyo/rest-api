<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

use App\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * @OA\Get(
     ** path="/departments",
     *   tags={"departments"},
     *   summary="Departments",
     *   operationId="departments",
     *   description="List all deportments + count employees + max salara + pagination",
     *
     *   @OA\Parameter(
     *      name="page",
     *      in="query",
     *      @OA\Schema(
     *           type="integer", example="2"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *)
     **/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deportaments = Department::paginate(2);

        $data = [];
        foreach($deportaments->items() as $v){
            $data[] = [
                'ID' => $v->id,
                'Name' => $v->name,
                'Total employees' => $v->employee()->count(),
                'Max salary' => $v->employee()->max('employees.salary')

            ];
        }
        return response()->json([
            'currentpage' => $deportaments->currentPage(),
            'prevpage' => $deportaments->previousPageUrl(),
            'nextpage' => $deportaments->nextPageUrl(),
            'lastpage' => $deportaments->lastPage(),
            'data' => $data
        ]);

    }

    /**
     * @OA\Post(
     ** path="/departments",
     *   tags={"departments"},
     *   summary="Departments",
     *   operationId="departments",
     *   description="Create a new departament",
     *
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *         required={"name"},
     *         @OA\Property(property="name", type="string", example="Narketing Dep.")
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *)
     **/
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
            'code' => '200',
            'message' => 'Entry added successfully'
        ]);

    }

    /**
     * @OA\Put(
     ** path="/departments/{id}",
     *   tags={"departments"},
     *   summary="Departments",
     *   operationId="departments",
     *   description="Update departments",
     *
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *         required={"name"},
     *         @OA\Property(property="name", type="string", example="Rename Narketing Dep.")
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *)
     **/
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
     * @OA\Delete(
     ** path="/departments/{id}",
     *   tags={"departments"},
     *   summary="Departments",
     *   operationId="departments",
     *   description="Delete department",
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *)
     **/
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $department = Department::findOrFail($id);

            if($department->employee()->count()) return response()->json(['message' => 'Unable to delete a department in which employees are present']);

            $department->delete();

            return response()->json([
                'id' => $department->id,
                'code' => '200',
                'message' => 'Entry successfully deleted'
            ]);
        } catch(\Exception $e){
            return response()->json([
                'messsage' => $e->getMessage(),
            ]);
        }
    }
}
