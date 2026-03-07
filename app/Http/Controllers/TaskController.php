<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
    
        $tasks = Task::where('user_id', auth()->id())
            ->when($keyword, function ($query, $keyword) {
                $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->latest()
            ->paginate(10);
    
        return view('tasks.index', compact('tasks', 'keyword'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|max:255',
    ]);

    Task::create([
        'title' => $request->title,
        'user_id' => auth()->id()
    ]);

    return redirect('/tasks');
}

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $task->update([
            'title' => $request->title
        ]);

        return redirect('/tasks');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('/tasks');
    }
}