<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Monolog\Logger;
use function Psy\debug;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $todos = $user->todos()->latest()->get();
        return response()->json($todos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $todo = $request->user()->todos()->create([
            'title' => $request->todo,
            'completed' => false,
        ]);
        return response()->json($todo, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $todo->update($request->all());
        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(null, 204);
    }
}
