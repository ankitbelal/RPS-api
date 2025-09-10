<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
          if($subjects){
         return response()->json($subjects);
        }
        else{
            return response()->json(['message' => 'No subjects found'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $data = $request->validated();
        $subject = Subject::create($data);
        return response()->json($subject, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $subject = Subject::find($id);
        if ($subject) {
            return response()->json($subject);
        } else {
            return response()->json(['message' => 'Subject not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subject = Subject::find($id);
        if ($subject) {
            $data = $request->validated();
            $subject->update($data);
            return response()->json($subject);
        } else {
            return response()->json(['message' => 'Subject not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $subject = Subject::find($id);
        if ($subject) {
            $subject->delete();
            return response()->json(['message' => 'subject deleted successfully']);
        } else {
            return response()->json(['message' => 'subject not found'], 404);
        }
    }
}
