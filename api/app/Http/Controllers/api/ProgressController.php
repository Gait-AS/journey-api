<?php

namespace App\Http\Controllers\api;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $teams = Team::all();


        $tasks_per_team = [];

        for ($i = 0; $i < count($teams); $i++) {
            $tasks = $teams[$i]->tasks()->get();
            $teamName = $teams[$i]->name;

            array_push($tasks_per_team, [$teamName => []]);

            for ($j = 0; $j < count($tasks); $j++) {

                if ($tasks[$j]->status == 'done') {
                    array_push($tasks_per_team[$i][$teamName], $tasks[$j]);
                }
            }
        }

        $counts = [];
        $total = 0;

        for ($i = 0; $i < count($tasks_per_team); $i++) {
            $teamName = array_keys($tasks_per_team[$i])[0];
            $count = count($tasks_per_team[$i][$teamName]);
            $total += $count;
            array_push($counts, [$teamName => $count]);
        }

        $percentageValue = 100 / $total;

        $percentage = [];

        // Set team count percentage
        for ($i = 0; $i < count($counts); $i++) {
            $teamName = array_keys($counts[$i])[0];
            $count = $counts[$i][$teamName];
            $percentageValue = 100 / $total;
            $percentageValue = $percentageValue * $count;
            array_push($percentage, [$teamName => $percentageValue]);
        }

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $percentage
        ]);
    }
}
