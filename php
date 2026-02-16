<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $tasks = $request->user()
            ->tasks()
            ->when($q, fn($query) => $query->where('title', 'like', "%{$q}%"))
            ->orderBy('is_done')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('tasks.index', compact('tasks', 'q'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
            'is_done' => ['nullable', 'boolean'],
        ]);

        $validated['is_done'] = (bool) $request->boolean('is_done');

        $request->user()->tasks()->create($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'タスクを作成しました。');
    }

    public function show(Request $request, Task $task)
    {
        $this->authorizeTaskOwner($request, $task);
        return view('tasks.show', compact('task'));
    }

    public function edit(Request $request, Task $task)
    {
        $this->authorizeTaskOwner($request, $task);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTaskOwner($request, $task);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
            'is_done' => ['nullable', 'boolean'],
        ]);

        $validated['is_done'] = (bool) $request->boolean('is_done');

        $task->update($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'タスクを更新しました。');
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorizeTaskOwner($request, $task);

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'タスクを削除しました。');
    }

    private function authorizeTaskOwner(Request $request, Task $task): void
    {
        abort_unless($task->user_id === $request->user()->id, 403);
    }
}
