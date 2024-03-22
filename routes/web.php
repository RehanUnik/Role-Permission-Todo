<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Task;
use Illuminate\Support\Facades\Route;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/wel', function () {
    return view('wel');
});

Route::get('/dashboard', function () {
    $manager = User::whereHas(
        'roles',
        function ($query) {
            $query->where('name', 'projectmanager');
        }
    )->count();
    $developer = User::whereHas('roles', function ($query) {
        $query->where('name', 'developer');
    })->count();

    $todos = Task::where('status', '=', 'todo')->count();
    $inprogress = Task::where('status', '=', 'inprogress')->count();
    $complete = Task::where('status', '=', 'complete')->count();
    $verified = Task::where('status', '=', 'verified')->count();
    $modification = Task::where('status', '=', 'modification')->count();

    return view('dashboard', compact('manager', 'developer', 'todos', 'inprogress', 'complete', 'verified', 'modification'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles');
        Route::get('/createrole', [RoleController::class, 'create'])->name('createrole');
        Route::post('/addrole', [RoleController::class, 'store'])->name('addrole');
        // Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        // Route::put('update/{id}', [RoleController::class, 'update'])->name('roles.update');
        // Route::delete('/destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');



        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/createuser', [UserController::class, 'create'])->name('createuser');
        Route::post('/adduser', [UserController::class, 'store'])->name('adduser');
        Route::get('/useredit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('userupdate/{id}', [UserController::class, 'update'])->name('user.update');
        // Route::delete('/userdestroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    Route::group(['middleware' => 'projectmanager'], function () {
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
        Route::get('/createproject', [ProjectController::class, 'create'])->name('createproject');
        Route::post('/addproject', [ProjectController::class, 'store'])->name('addproject');
        Route::get('projectedit/{id}', [ProjectController::class, 'edit'])->name('editproject');
        Route::put('updateproject/{id}', [ProjectController::class, 'update']);
    });

    Route::group(['middleware' => 'task'], function () {

        Route::get('tasks', [TaskController::class, 'index'])->name('tasks');
        Route::get('createtask', [TaskController::class, 'create'])->name('createtask');
        Route::post('addtask', [TaskController::class, 'store'])->name('addtask');
        Route::get('images/{id}', [TaskController::class, 'images']);
        Route::put('uploadimg/{id}', [TaskController::class, 'updateImage']);
        Route::get('deleteimg/{id}/{image}', [TaskController::class, 'destroyImage']);
        Route::get('taskedit/{id}', [TaskController::class, 'edit']);
        Route::put('updatetask/{id}', [TaskController::class, 'update']);
        Route::get('getDevelopersByProject/{id}', [TaskController::class, 'getDevelopersByProject']);
        Route::put('/statusupdate', [TaskController::class, 'statusupdate'])->name('statusupdate');
    });
});

require __DIR__ . '/auth.php';
