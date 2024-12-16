<?php

namespace App\Http\Controllers\Admin;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TodoController extends Controller
{
    public function addTodo(Request $request)
    {
        $request->validate(['task_name' => 'required']);

        Todo::create([
            'task_name' => $request->task_name,
            'admin_id' => auth()->user()->id, // Simpan admin ID
        ]);

        return redirect()->back()->with('success', 'Task added successfully.');
    }

    public function destroyTodo($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }

    public function markAsCompleted($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->status = 'completed';
        $todo->save();

        return redirect()->back()->with('success', 'Task marked as completed!');
    }
}
