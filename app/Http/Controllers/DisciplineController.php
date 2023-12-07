<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Discipline;

class DisciplineController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'emment' => 'required|array',
            'material' => 'required|string',
            'bibliography' => 'required|string',
            'semester' => 'required|integer',
            'schedules' => 'required|array',
            'active' => 'required|boolean'
        ]);

        $discipline = new Discipline();
        $discipline->name = $request->input('name');
        $discipline->description = $request->input('description');
        $discipline->emment = $request->input('emment');
        $discipline->material = $request->input('material');
        $discipline->bibliography = $request->input('bibliography');
        $discipline->semester = $request->input('semester');
        $discipline->schedules = $request->input('schedules');
        $discipline->active = $request->input('active');

        try {
            $discipline->save();
            return response()->json($discipline, 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error on save discipline','th' => $th], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $verification = $this->verification('integer', $id, 'id is not integer');
        if(!$verification) return response()->json(['message' => $verification], 400);

        $data = $request->only([
            'name', 'description', 'emment', 'material',
            'bibliography', 'semester', 'schedules', 'active'
        ]);

        try {
            $discipline = Discipline::find($id);
            $discipline->fill($data);
            $discipline->save();
            
            return response()->json($discipline, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error on update especific discipline','th' => $th], 500);
        }
    }

    public function delete($id)
    {
        $verification = $this->verification('integer', $id, 'id is not integer');
        if(!$verification) return response()->json(['message' => $verification], 400);

        try {
            $discipline = Discipline::find($id);
            $discipline->delete();
            return response()->json(['message' => 'Discipline deleted'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error on delete especific discipline','th' => $th], 500);
        }
    }

    public function list_discipline($id)
    {
        $verification = $this->verification('integer', $id, 'id is not integer');
        if(!$verification) return response()->json(['message' => $verification], 400);

        try {
            $discipline = Discipline::find($id);
            return response()->json($discipline, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error on find especific discipline','th' => $th], 500);
        }
    }

    public function list_all_discplines()
    {
        try {
            $disciplines = Discipline::all();
            return response()->json($this->formatting_return_disciplines($disciplines), 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error on find all disciplines','th' => $th], 500);
        }
    }

    public function verification($type, $data, $message)
    {
        if (gettype($data) !== $type) return $message; 

        return true;
    }

    public function formatting_return_disciplines($disciplines)
    {
        $disciplines_formated = [];

        foreach ($disciplines as $key => $discipline) {
            $disciplines_formated[$discipline->semester][] = $discipline;
        }

        return $disciplines_formated;
    }
}
