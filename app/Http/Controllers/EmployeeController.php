<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * @OA\Get(
     ** path="/employees",
     *   tags={"employees"},
     *   summary="Employees",
     *   operationId="employees",
     *   description="List all employees + pagination",
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
        $employees = Employee::paginate(2);

        $data = [];
        foreach($employees->items() as $v){
            $data[] = [
                'ID' => $v->id,
                'Full name' => $v->firstname . ' ' . $v->lastname . ' ' . $v->patronymic,
                'Gender' => $v->gender,
                'Salary' => $v->salary
            ];
        }
        return response()->json([
            'currentpage' => $employees->currentPage(),
            'prevpage' => $employees->previousPageUrl(),
            'nextpage' => $employees->nextPageUrl(),
            'lastpage' => $employees->lastPage(),
            'data' => $data
        ]);
    }

    /**
     * @OA\Post(
     ** path="/employees",
     *   tags={"employees"},
     *   summary="Employees",
     *   operationId="employees",
     *   description="Create a new empoyee",
     *
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *         required={"firstname", "lastname", "patronymic", "salary", "departaments"},
     *         @OA\Property(property="firstname", type="string", example="Ivan"),
     *         @OA\Property(property="lastname", type="string", example="Ivanov"),
     *         @OA\Property(property="patronymic", type="string", example="Olehovich"),
     *         @OA\Property(property="gender", type="string", example="Female"),
     *         @OA\Property(property="salary", type="integer", example="1900"),
     *         @OA\Property(property="departaments", type="json", example="{'0': 1, '1': 3}")
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
    public function store(EmployeeRequest $request)
    {

        $employee = new Employee;

        DB::beginTransaction();

        $employee->fill($request->all())->save();


        try {
            $employee->departments()->attach($request->departments);
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'messsage' => 'Error. At least 1 department does not exist',
            ]);
        }
        DB::commit();

        return response()->json([
            'id' => $employee->id,
            'code' => '200',
            'message' => 'Entry added successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @OA\Put(
     ** path="/employees/{id}",
     *   tags={"employees"},
     *   summary="Employees",
     *   operationId="employees",
     *   description="Update a employee",
     *
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *         required={"firstname", "lastname", "patronymic", "salary", "departaments"},
     *         @OA\Property(property="firstname", type="string", example="Ivan"),
     *         @OA\Property(property="lastname", type="string", example="Ivanov"),
     *         @OA\Property(property="patronymic", type="string", example="Olehovich"),
     *         @OA\Property(property="gender", type="string", example="Female"),
     *         @OA\Property(property="salary", type="integer", example="1900"),
     *         @OA\Property(property="departaments", type="json", example="{'0': 1, '1': 3}")
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
    public function update(EmployeeRequest $request, $id)
    {
        try {


            $employee = Employee::findOrFail($id);

            DB::beginTransaction();

            $employee->fill($request->all())->save();


            try {
                $employee->departments()->detach();
                $employee->departments()->attach($request->departments);
            } catch(\Exception $e){
                DB::rollBack();
                return response()->json([
                    'messsage' => 'Error. At least 1 department does not exist',
                ]);
            }
            DB::commit();


            return response()->json([
                'id' => $employee->id,
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
     ** path="/employees/{id}",
     *   tags={"employees"},
     *   summary="Employees",
     *   operationId="employees",
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return response()->json([
                'id' => $employee->id,
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
