<?php

namespace App\Http\Controllers\api;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $team_id)
    {
        $team = $request->user()->team()->where('id', $team_id)->first();

        if (!$team) {
            return response()->json([
                'status' => false,
                'message' => 'Team not found or user does not have access to this team',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'none',
            'data' => $team
        ], 200);
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

    public function members(Request $request)
    {
        $team = $request->user()->team;

        if (!$team) {
            return response()->json([
                'status' => false,
                'message' => 'Team not found or user does not have access to this team',
                'data' => []
            ], 404);
        }


        $members = User::where('team_id', $team->id)->get();

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $members
        ], 200);
    }

    public function addMember(Request $request)
    {
        // $team = $request->user()->team()->where('id', $request->team_id)->first();

        $team = Team::find($request->team_id);

        if (!$team) {
            return response()->json([
                'status' => false,
                'message' => 'Team not found or user does not have access to this team',
                'data' => []
            ], 404);
        }

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => []
            ], 404);
        }

        $user->team_id = $request->team_id;
        $user->update();

        return response()->json([
            'status' => true,
            'message' => $user->first_name . ' has been added to ' . $team->name,
            'data' => ['team' => $team, 'user' => $user]
        ], 200);
    }

    public function me(Request $request)
    {
        $team = $request->user()->team;

        if (!$team) {
            return response()->json([
                'status' => false,
                'message' => 'Team not found or user does not have access to this team',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $team
        ], 200);
    }

    public function leader(Request $request)
    {
        $leader = $request->user()->team()->first()->leader();

        if (!$leader) {
            return response()->json([
                'status' => false,
                'message' => 'Team not found or user does not have access to this team',
                'data' => []
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $leader
        ], 200);
    }
}
