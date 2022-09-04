<?php

use Illuminate\Http\Request;
use App\Http\Middleware\RoleLeader;
use App\Http\Middleware\RoleMaster;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('/auth/register', [\App\Http\Controllers\api\AuthController::class, 'register'])->name('user.register');
Route::post('/auth/authenticate', [\App\Http\Controllers\api\AuthController::class, 'authenticate'])->name('user.authenticate');



/**
 *
 * PROTECTED ROUTES FOR MEMBERS
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        Log::debug('adad');
        return response()->json([
            'status' => true,
            'message' => 'User Authenticated',
            'data' => $request->user()
        ], 200);
    });
    Route::get('/logout', [\App\Http\Controllers\api\AuthController::class, 'logout'])->name('user.logout');
    Route::get('/logout/force', [\App\Http\Controllers\api\AuthController::class, 'logoutForce'])->name('user.logout.force');


    // Route::prefix('projects')->group(function () {
    //     Route::get('/my', [\App\Http\Controllers\api\ProjectController::class, 'myProjects'])->name('projects.my');
    //     Route::get('/{project_id}', [\App\Http\Controllers\api\ProjectController::class, 'show'])->name('projects.show');

    //     Route::prefix('members')->group(function () {
    //         Route::post('/add', [\App\Http\Controllers\api\ProjectController::class, 'addUserToProject'])->name('projects.members.add');
    //     });
    // });

    // PROGRESSBAR
    Route::get('/progress', [\App\Http\Controllers\api\ProgressController::class, 'index'])->name('progress.index');


    // TEAM ROUTES
    Route::prefix('teams')->group(function () {
        // Returns my team
        Route::get('/me', [\App\Http\Controllers\api\TeamController::class, 'me'])->name('team.me');

        // Returns team leader information
        Route::get('/me/leader', [\App\Http\Controllers\api\TeamController::class, 'leader'])->name('team.leader');

        // Returns members of a team
        Route::get('/members', [\App\Http\Controllers\api\TeamController::class, 'members'])->name('team.members');

        // Adds a member to a team
        Route::post('/members', [\App\Http\Controllers\api\TeamController::class, 'addMember'])->name('team.add.member');
    });



    Route::prefix('tasks')->group(function () {
        Route::get('/me', [\App\Http\Controllers\api\TaskController::class, 'myTasks'])->name('tasks.me');
        Route::post('/me/new', [\App\Http\Controllers\api\TaskController::class, 'newTask'])->name('task.create');

        Route::get('/me/delete/{id}', [\App\Http\Controllers\api\TaskController::class, 'deleteTask'])->name('task.delete');
        Route::get('/me/{id}', [\App\Http\Controllers\api\TaskController::class, 'myTask'])->name('tasks.task');

        Route::post('/me/{id}', [\App\Http\Controllers\api\TaskController::class, 'updateTask'])->name('task.update');
    });


    /*************************************************
     *
     * PROTECTED ROUTES FOR LEADER
     *
     **************************************************/
    Route::middleware([RoleLeader::class])->group(function () {
        Route::get('/leader', function (Request $request) {
            return 'You are leader or master!';
        });
    });


    /*************************************************
     *
     * PROTECTED ROUTES FOR MASTER
     *
     **************************************************/
    Route::middleware([RoleMaster::class])->group(function () {
        Route::get('/master', function (Request $request) {
            return 'You are master!';
        });
    });
});
