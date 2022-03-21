<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'asc')->get();
        return view('tasks', compact('tasks'));
    }
    //
    public function save(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'start_at' => 'required'
            ],
            [
                'start_at.required' => 'The duration field is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }


        $task = new Task;
        $task->name = $request->name;
        $task->start_at = date('Y-m-d H:m', strtotime($request->start_at));
        $task->end_at = date('Y-m-d H:m', strtotime($request->end_at));
        $task->save();

        return redirect('/');
    }

    public function report()
    {
        $tasks = Task::select('name', \DB::raw('TIMESTAMPDIFF(HOUR,start_at, end_at) as duration'))->get()->toArray();

        $task = array_column($tasks, 'name');
        $duration = array_column($tasks, 'duration');

        return view('chart')->with('task', json_encode($task, JSON_NUMERIC_CHECK))->with('duration', json_encode($duration, JSON_NUMERIC_CHECK));
    }

    public function delete($id)
    {
        Task::findOrFail($id)->delete();

        return redirect('/');
    }
}
