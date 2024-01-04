<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Carbon\Carbon;
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

    public function show(string $id)
    {
        $todo = Todo::find($id);

        if(!$todo)
        {
            return response()->json(["message" => "Record not found"], 404);
        }

        return response()->json($todo, 200);

    }

    public function destroy(string $id) : object{
        $todo = Todo::where('id', $id);

        if($todo->exists()){
            $todo->delete();
            return response('', 204); // HTTP no content
        } else {
            return response()->json(["message" => "Record not found"], 404);
        }

    }


    public function flagDone(string $id): object {
        $todo = Todo::find($id);

        if($todo->exists()){
            $todo->done = true;
            $todo->done_at = Carbon::now();
            $todo->save();
            return response()->json($todo, 200);
        } else {
            return response()->json(["message" => "Record not found"], 404);
        }

    }

}
