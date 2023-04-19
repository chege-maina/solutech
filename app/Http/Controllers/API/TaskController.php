<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationEmail;
use App\Models\Task;
use App\Models\User_task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function listTasks()
    {

        $task = Task::with('status')->orderBy('id')->get();
        return response()->json([
            'data' => $task
        ]);
    }
    public function addTask(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'due_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'status_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => "Fill in all the Fields Below Properly"
            ];
            return response()->json($response);
        }


        $input = $request->all();
        $input['start_time'] = date("Y-m-d H:i:s", strtotime($input['start_time']));
        $input['end_time'] = date("Y-m-d H:i:s", strtotime($input['end_time']));
        $input['due_date'] = date("Y-m-d H:i:s", strtotime($input['due_date']));

        try {

            Task::create($input);

            $response = [
                'success' => true,
                'message' => 'Task Created successfully'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'message' => "Database Failed" . $th
            ];
            return response()->json($response);
        }
    }
    public function deleteTask(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            $task = Task::findOrfail($id);

            $task->delete();
            $response = [
                'success' => true,
                'message' => 'Task deleted successfully'
            ];

            return response()->json($response, 200);
        }
    }
    public function editTask(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'due_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'status_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => "Fill in all the Fields Below Properly"
            ];
            return response()->json($response);
        }

        $task = Task::where('id', $request->id)->first();
        $task->name = $request->get('name');
        $task->description = $request->get('description');
        $task->description = $request->get('description');
        $task->start_time = date("Y-m-d H:i:s", strtotime($request->get('start_time')));
        $task->due_date = date("Y-m-d H:i:s", strtotime($request->get('due_date')));
        $task->end_time = date("Y-m-d H:i:s", strtotime($request->get('end_time')));
        $task->status_id = $request->get('status_id');
        $task->save();
        $response = [
            'success' => true,
            'message' => 'Task Edited successfully'
        ];

        return response()->json($response, 200);
    }
    public function assignTask(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'task_id' => 'required',
            'remarks' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => "Fill in all the Fields Below Properly"
            ];
            return response()->json($response);
        }

        $mailData = [
            'email' => $request->email,
            'name' => $request->userName,
            'title' => " Task Assignment",
            'subject' => "Task Assignment",
            'message' => "This message is to let you know that you have been assigned a task
            starting on " . $request->start_time . ". The task is due on " . $request->due_date . ".",
            'bold' => "Use the link below to view this and other of your tasks.",
            'linktext' => "Click here to activate your account...",
            'link' => env('APP_URL') . "/dashboard"
        ];
        $input = $request->all();

        try {
            Mail::to($request->email)->send(new RegistrationEmail($mailData));
            User_task::create($input);
            $task = Task::where('id', $request->task_id)->first();
            $task->status_id = 2;
            $task->save();

            $response = [
                'success' => true,
                'message' => 'Task Assigned successfully'
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'success' => false,
                'message' => "Database Failed" . $th
            ];
            return response()->json($response);
        }
    }
    public function userTasks($id)
    {

        $task = User_task::with('task.status')->where('user_id', '=', $id)->orderBy('id')->get();
        return response()->json([
            'data' => $task
        ]);
    }
    public function completeTask(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            $task = Task::where('id', $id)->first();
            $task->status_id = 3;
            $task->save();
            $response = [
                'success' => true,
                'message' => 'Task Completed successfully'
            ];

            return response()->json($response, 200);
        }
    }
}