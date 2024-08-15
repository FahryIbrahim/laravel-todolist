<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::all()->map(function ($todo) {
            $todo->formatted_deadline = Carbon::parse($todo->deadline)->format('d M Y');
            return $todo;
        });

        return view('home', ['todos' => $todos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Validate
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate
        $data = $request->validate([
            'title' => ['required'],
            'desc' => ['required'],
            'deadline' => ['date'],
            'completed' => ['required', 'boolean']
        ]);
        Todo::create($data);
        // Redirect
        return back()->with('success', 'Your Todo was Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        return view('home', ['todo' => $todo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'desc' => 'required|string',
            'deadline' => 'nullable|date',
            'completed' => 'required|boolean'
        ]);

        $todo->update($data);

        if ($request->expectsJson()) {
            return response()->json($todo);
        }

        return back()->with('success', 'Your Todo was Updated');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return back()->with('success', 'Your Todo was Deleted');
    }
}
