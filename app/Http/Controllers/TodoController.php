<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

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
        // TODO: should probably be in store instead
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
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'completed' => ['required', 'boolean'],
        ]);

        abort_unless($request->user()->id === $todo->user_id, 403);

        $todo->update([
            'title' => $validated['title'],
            'completed' => $validated['completed'],
        ]);

        return response()->json($todo->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(null, 204);
    }

    public function trash(Request $request)
    {
        $user = $request->user();
        $trashedTodos = Todo::onlyTrashed()
            ->where('todos.user_id', $user->id)
            ->get();
        return response()->json($trashedTodos);
    }

    public function restore(Request $request, $todo)
    {
        $restoredTodo = Todo::onlyTrashed()
            ->where('todo_id', $todo)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $restoredTodo->restore();

        return response()->json($restoredTodo);
    }

    public function forceDelete(Request $request, $todo)
    {
        $todo = Todo::withTrashed()
            ->where('todo_id', $todo)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $todo->forceDelete();

        return response()->json([
            'message' => 'Todo permanently deleted',
        ]);
    }
}
