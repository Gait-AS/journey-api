<?php

namespace App\Http\Controllers\api;

use App\Models\Task;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        $teams = Team::all();

        $totalTasks = Task::all()->count();
        $teamTaskCounter = ['total' => $totalTasks, 'teams' => []];

        for ($i = 0; $i < count($teams); $i++) {
            $tasks = $teams[$i]->tasks()->get();
            $teamName = $teams[$i]->name;

            $teamTasks = $teams[$i]->tasks()->count();
            $teamDoneTasks = $teams[$i]->tasks()->where('status', 'done')->count();
            $teamNotDoneTasks = $teams[$i]->tasks()->where('status', '!=', 'done')->count();
            array_push($teamTaskCounter['teams'], [
                'name' => $teamName,
                'total_tasks' => $teamTasks,
                'done_tasks' => $teamDoneTasks,
                'not_done_tasks' => $teamNotDoneTasks,
                'percentage_done' => ($teamDoneTasks / $totalTasks) * 100
            ]);


            // array_push($tasks_per_team, [$teamName => []]);

            // for ($j = 0; $j < count($tasks); $j++) {

            //     if ($tasks[$j]->status == 'done') {
            //         array_push($tasks_per_team[$i][$teamName], $tasks[$j]);
            //         array_push($teamTaskCounter[$teamName]);
            //         $doneTasks++;
            //         $totalTasks++;
            //     } else {
            //         $totalTasks++;
            //     }
            // }
        }

        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $teamTaskCounter
        ]);

        $counts = [];
        $total = 0;

        // for ($i = 0; $i < count($tasks_per_team); $i++) {
        //     $teamName = array_keys($tasks_per_team[$i])[0];
        //     $count = count($tasks_per_team[$i][$teamName]);
        //     $total += $count;
        //     array_push($counts, [$teamName => $count]);
        // }

        // $percentageValue = ($doneTasks / $totalTasks) * 100;

        // $percentage = [];

        // // Set team count percentage
        // for ($i = 0; $i < count($counts); $i++) {
        //     $teamName = array_keys($counts[$i])[0];
        //     $count = $counts[$i][$teamName];
        //     $percentageValue = 100 / $total;
        //     $percentageValue = $percentageValue * $count;
        //     array_push($percentage, [$teamName => $percentageValue]);
        // }

        // return response()->json([
        //     'status' => true,
        //     'message' => 'success',
        //     'data' => $percentage
        // ]);
    }
}
