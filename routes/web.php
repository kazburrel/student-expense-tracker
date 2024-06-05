<?php

use App\Http\Controllers\ProccessFormController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use OpenAI\Laravel\Facades\OpenAI;

Route::view('/', 'dashboard')->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
Route::post('/image-process', [ProccessFormController::class, 'reviewForm'])->name('review.form');
Route::get('/categories', [ProccessFormController::class, 'getCategories'])->name('get.categories');

Route::get('/ai', function () {
    $result =  OpenAI::chat()->create([
        'model' => 'gpt-4-vision-preview',
        'messages' => [
            [
                'role' => 'user',
                'content' => 'Tell me something about laravel i may not know!'
            ],
        ],
    ]);

    echo $result->choices[0]->message->content;
});
