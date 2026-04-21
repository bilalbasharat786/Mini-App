<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Task;

// 1. Tasks dikhane ka route
Route::get('/', function () {
    $tasks = Task::all(); // Database se sab tasks nikalo
    return view('todo', compact('tasks')); // Frontend (todo.blade.php) ko bhej do
});

// 2. Naya Task add karne ka route
Route::post('/add-task', function (Request $request) {
    Task::create(['title' => $request->task_name]);
    return back(); // Wapas usi page par le jao
});

// 3. Task delete karne ka route
Route::get('/delete-task/{id}', function ($id) {
    Task::destroy($id);
    return back();
});