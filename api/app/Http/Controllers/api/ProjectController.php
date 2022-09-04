<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return 'TBH';
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
    public function show(Request $request, $project_id)
    {
        $project = $request->user()->projects()->where('project_id', $project_id)->first();

        if (!$project) {
            return response()->json([
                'status' => false,
                'message' => 'Not found, or you do not have permission to view this project'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Project Found',
            'data' => $project
        ], 200);
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

    public function myProjects(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'projects',
            'data' => $request->user()->projects
        ], 200);
    }

    public function addUserToProject(Request $request)
    {
        $request->validate([
            'user_id' => 'integer|required',
            'project_id' => 'integer|required',
            'role' => 'string|sometimes',
        ]);

        $userId = $request->user_id;


        $user = User::find($userId);

        // If user is not found
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        // If user already exists in project
        if ($user->projects()->where('project_id', $request->project_id)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'User already added to project'
            ], 400);
        }



        $user->projects()->attach($request->project_id);

        return response()->json([
            'status' => true,
            'message' => 'User added to project successfully',
        ], 200);
    }
}
