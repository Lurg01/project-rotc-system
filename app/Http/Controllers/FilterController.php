<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Http\Resources\Student\StudentResource;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;


class FilterController extends Controller
{
    public function store(Request $request)
    {
        
        $semester = $request->input('semester');
        $year = $request->input('year');
        
        if (!Schema::hasTable('filter')) {
            Schema::create('filter', function (Blueprint $table) {
                $table->id();
                $table->integer('semester');
                $table->string('year');
            });

        } else {
            DB::table('filter')->truncate();
            if($semester && $year) {
                DB::table('filter')->insert([
                    'semester' => $semester,
                    'year' => $year
                ]);
            }
        }

        return redirect()->back()->with('success', ' Semester and Year selected successfully !, proceed by entering OTP . .');
    }
}
