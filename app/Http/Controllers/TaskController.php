<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

/*  HTTP STATUS CODES
* 200 OK
* 201 RESOURCE CREATED
* 202 ACTION QUEUED
* 204 OK WITH NO RESPONSE CONTENT

* 400 BAD REQUEST
* 404 RESOURCE NOT FOUND
*/

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        $body = ['data' => $tasks];  // Data wrapping.

        return response($body, 200)->header('Content-type', 'application/json');
    }

    public function store()
    {
        $data = request()->validate([
            'description' => 'required|max:1000',
            'deadline' => 'required|date'
        ]);

        $task = Task::create($data);

        $body = ['data' => $task];

        return response($body, 201)->header('Content-type', 'application/json');
    }

    public function show(Task $task)
    {
        $body = ['data' => $task];
        return response($body, 200)->header('Content-type', 'application/json');
    }

    public function update(Task $task)
    {
        $data = request()->validate([
            'description' => 'required|max:1000',
            'deadline' => 'date'
        ]);
        
        $task->update($data);

        $body = ['data' => $task];
        
        return response($body, 200)->header('Content-type', 'application/json');;
    }

    public function destroy(Task $task)
    {
        $id = $task->id;
        $task->delete();
        $body = ['data' => ['message' => 'Task '. $id . ' deleted.'] ];
            
        return response($body, 200)->header('Content-type', 'application/json');
    }
}
