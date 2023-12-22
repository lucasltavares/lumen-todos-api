<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
           'title' => 'required',
           'description' => 'required'
        ]);

        $model = Todo::create($request->all());

        return response()->json([
            "message" => 'Todo Record created.'
        ], 201);
    }

    public function show($id)
    {
        $todo = Todo::where('id', $id)->get();

        return response()->json($todo, 200);
    }

}
