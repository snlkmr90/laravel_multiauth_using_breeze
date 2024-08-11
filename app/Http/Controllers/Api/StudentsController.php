<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['students'=>Student::orderBy('id', 'DESC')->get(),'status'=>200],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,StoreStudentRequest $student)
    {
        $student = Student::create([
            'name'=>$request->name,
            'age'=>$request->age,
            'gender'=>$request->gender,
        ]);
        if($student){
            return response()->json(['message'=>'student added successfully !','status'=>200]);
        }
        return response()->json(['message'=>'error while creating student !','status'=>400]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if($student){
            return response()->json(['student'=>$student,'status'=>200]);
        }
        return response()->json(['message'=>'student not found !','status'=>400]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id,StoreStudentRequest $student)
    {
        $student = Student::find($id);
        if(!$student){
            return response()->json(['message'=>'student not found !','status'=>400]);
        }
        $student->name = $request->name;
        $student->age = $request->age;
        $student->gender = $request->gender;
        if($student->save()){
            return response()->json(['message'=>'student updated !','status'=>200]);
        }
        return response()->json(['message'=>'error in updating student !','status'=>400]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        if(!$student){
            return response()->json(['message'=>'student not found !','status'=>400]);
        }
        if($student->destroy($id)){
            return response()->json(['message'=>'student updated !','status'=>200]);
        }
        return response()->json(['message'=>'error in deleting student !','status'=>400]);
    }
    public function deleteMultiple(Request $request){
        if($request->get('mcb')){
            if(Student::destroy($request->get('mcb'))){
                return response()->json(['message'=>'deleted multiple !','status'=>200]);
            }
        }
        return response()->json(['message'=>'unable to delete !','status'=>400]);
    }
}
