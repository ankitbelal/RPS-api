<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProgramRequest;
use App\Models\programs\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::all();
        if($programs){
         return response()->json($programs);
        }
        else{
            return response()->json(['message' => 'No programs found'], 404);
        }
    }

    public function show($id)
    {
        $program = Program::find($id);
        if ($program) {
            return response()->json($program);
        } else {
            return response()->json(['message' => 'Program not found'], 404);
        }
    }

    public function store(ProgramRequest $request)
    {
        $data = $request->validated();
        $program = Program::create($data);
        return response()->json($program, 201);
    }

    public function update(ProgramRequest $request, $id)
    {
        $program = Program::find($id);
        if ($program) {
            $data = $request->validated();
            $program->update($data);
            return response()->json($program);
        } else {
            return response()->json(['message' => 'Program not found'], 404);
        }
    }
    public function destroy($id)
    {
        $program = Program::find($id);
        if ($program) {
            $program->delete();
            return response()->json(['message' => 'Program deleted successfully']);
        } else {
            return response()->json(['message' => 'Program not found'], 404);
        }
    }

    // should import the package for excel data map and download sample data
    // public function bulkRegisterProgram(ProgramRequest $request)
    // {
    //     $data = $request->validated();
    //     $programs = Program::insert($data);
    //     return response()->json($programs, 201);
    // }

}