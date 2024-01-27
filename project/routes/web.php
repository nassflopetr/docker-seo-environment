<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ShowController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', IndexController::class)->name('/');

Route::get('/contacts', function () {
    return view('contacts', [
        'metadata' => [
            'h1' => 'Театральний Портал',
            'title' => 'Контакти - Театральний Портал',
            'description' => 'Зв\'яжіться з Театральним Порталом за допомогою контактної інформації. Ми завжди раді вам надати інформацію про театральні вистави та допомогти з покупкою квитків.',
            'keywords' => 'контакти, театр, театральний портал, зв\'язок',
            'og:title' => 'Контакти - Театральний Портал',
            'og:description' => 'Зв\'яжіться з Театральним Порталом за допомогою контактної інформації. Ми завжди раді вам надати інформацію про театральні вистави та допомогти з покупкою квитків.',
        ],
    ]);
})->name('contacts');

Route::match(['get', 'post'], '/shows/{id?}', [ShowController::class, 'router'])->where('id', '[0-9]+')->name('shows');
