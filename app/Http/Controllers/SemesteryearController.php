<?php

namespace App\Http\Controllers;

use App\Models\semesteryear;
use App\Models\Student;
use App\Http\Requests\StoresemesteryearRequest;
use App\Http\Requests\UpdatesemesteryearRequest;

class SemesteryearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leave = semesteryear::all();
        $data = json_decode('{}'); 
        $data->message = "successfully fetch all";
        $data->success = true;
        $data->data = $leave;
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $a = new semesteryear;
        // $a->fill($request->validated());
        // $data = json_decode('{}'); 
        // $data->success = true;
        // $data->data = $a;
        // return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoresemesteryearRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoresemesteryearRequest $request)
    {
        $c = Student::all()->count();
        $a = new semesteryear;
        $a->fill($request->validated());
        $a->student_id = null;
        $c+=1;
        $data = json_decode('{}'); 
        $d = semesteryear::where('student_id', '=', $c)->first();
        if(!$d){
            if($a->save()){
                session()->put('create_stud_id', $a->id);
                $data->success = true;
                $data->data = $a;
                return response()->json($data);
            }
            $data->success = false;
            return response()->json($data);
        }
        session()->put('create_stud_id', $c);
        $data->success = true;
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\semesteryear  $semesteryear
     * @return \Illuminate\Http\Response
     */
    public function show( $semesteryear)
    {
        $a = semesteryear::find($id);
        $data = json_decode('{}'); 
        $data->success = true;
        $data->data = $a;
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\semesteryear  $semesteryear
     * @return \Illuminate\Http\Response
     */
    public function edit(semesteryear $semesteryear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatesemesteryearRequest  $request
     * @param  \App\Models\semesteryear  $semesteryear
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatesemesteryearRequest $request, semesteryear $semesteryear)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\semesteryear  $semesteryear
     * @return \Illuminate\Http\Response
     */
    public function destroy(semesteryear $semesteryear)
    {
        //
    }
}
