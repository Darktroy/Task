<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Auth::user()->tasks()->orderBy('created_at', 'desc')->get();
        return view('tasks.index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        Auth::user()->tasks()->create($request->validated());
        session()->flash('notif.success', 'Task created successfully!');
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        if(Auth::user()->id != $task->user_id)
        return abort(403);

        return response()->view('tasks.show', [
            'task' =>$task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if(Auth::user()->id != $task->user_id)
        return abort(403);

        return response()->view('tasks.form', [
            'task' =>$task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskStoreRequest $request, Task $task)
    {
        if(Auth::user()->id != $task->user_id)
        return abort(403);

        $task->update($request->validated());
        session()->flash('notif.success', 'Task updated successfully!');
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if(Auth::user()->id != $task->user_id)
        return abort(403);

        $task->delete();
        session()->flash('notif.success', 'Task deleted successfully!');
        return redirect()->route('tasks.index');
    }
}
