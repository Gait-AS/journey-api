<?php

namespace App\Http\Controllers\api;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Middleware\RoleLeader;
use App\Http\Middleware\RoleMaster;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;



class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function myTasks(Request $request)
    {
        $tasks = $request->user()->tasks()->get();
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $tasks
        ]);
    }

    public function newTask(Request $request)
    {
        try {
            $created_by = (int) $request->user()->id;
            $request->assigned_to = $request->user()->id;


            // WORKING REAL LIFE SCENARIO
            // $request->assigned_to = ($request->user()->role === 'member') ? $request->user()->id : (int) $request->assigned_to;


            if (!$request->assigned_to) {
                return response()->json([
                    'status' => false,
                    'message' => 'assigned_to is required',
                    'data' => []
                ], 400);
            }

            // Validate request
            $validate = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:255',
                    'content' => 'sometimes|string|max:1020',
                    'status' => ['required', Rule::in(Task::STATUS)],
                    'team_id' => 'required|integer|exists:teams,id',
                    'assigned_to' => 'sometimes|integer|exists:users,id',
                ]
            );

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validate->errors(),
                    'data' => []
                ], 401);
            }


            $task = Task::create([
                'name' => $request->name,
                'content' => $request->content,
                'status' => $request->status,
                'team_id' => $request->team_id,
                'assigned_to' => $request->assigned_to,
                'created_by' => $created_by,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $task
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
                'data' => []
            ], 500);
        }

        $request->validate([]);

        if ($request->validated()) {
            $task = Task::create([
                'name' => $request->name,
                'content' => $request->content,
                'status' => $request->status,
                'team_id' => $request->team_id,
                'assigned_to' => $request->assigned_to,
                'created_by' => $created_by,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $task
            ]);
        }


        return response()->json([
            'status' => false,
            'message' => 'failed',
            'data' => $request->validated()
        ]);
    }
}
