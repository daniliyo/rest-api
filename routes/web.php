<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DepartmentController;
use App\Models\Department;
use App\Models\Employee;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $employees = Department::paginate(2);
    dd();
echo $employees->currentPage();
    //echo $employees->prevPage();
    dd($employees);

    $data = [];
    foreach($employees->items() as $v){
        $data[] = [
          'Full name' => $v->firstname . ' ' . $v->lastname . ' ' . $v->patronymic,
          'Gender' => $v->gender,
          'Salary' => $v->salary
        ];
    }
    return response()->json([
        'currentpage' => $employees->currentPage(),
        //'prevpage' => ($employees->prevPage) ?: NULL,
        'nextpage' => $employees->nextPageUrl(),
        'lastpage' => $employees->lastPage(),
        'data' => $data
    ]);






    //dd($employees->items());
    $result = array_map(function($object){
        return (array) $object;
    }, $employees->items());
    //eturn response()->json([$]);
    dd($result);


    return 1;
    echo '1';
    $department = Department::find(1);
    var_dump($department->employee()->count());
    echo '<br>';

    echo '2';
    $department = Department::find(2);
    var_dump($department->employee()->count());
    echo '<br>';

    echo '3';
    $department = Department::find(3);
    var_dump($department->employee()->count());
    echo '<br>';

    echo '4';
    $department = Department::find(4);
    var_dump($department->employee()->count());
    echo '<br>';



    //dd($department->employee()->count());
});
