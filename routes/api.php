<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\JobNoteController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

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

Route::group(['prefix' => 'jobs', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [JobController::class, 'index']);
    Route::group(['prefix' => '{job}'], function () {
        Route::get('/', [JobController::class, 'show']);

        Route::patch('/status', [JobController::class, 'updateStatus']);
        Route::delete('/', [JobController::class, 'destroy']);

        Route::group(['prefix' => 'notes'], function () {
            Route::post('/', [JobNoteController::class, 'store']);
            Route::put('/{jobNote}', [JobNoteController::class, 'update']);
        });
    });
});

//login
Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
})->name('login');
