<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/createTicketView', [TicketController::class, 'createTicketView'])->name('createTicketView');
Route::post('/store-ticket', [TicketController::class, 'createTicket'])->name('tickets.store');
Route::get('/edit-ticket/{id}', [TicketController::class, 'editTicketIndex'])->name('tickets.edit');
Route::put('/update-ticket/{id}', [TicketController::class, 'updateUserTicket'])->name('tickets.update');
Route::delete('/destroy-ticket/{id}', [TicketController::class, 'destroyUserTicket'])->name('tickets.destroy');

Route::get('/tickets/categories/{categoryId}', [TicketController::class, 'ticketsByCategories'])->name('tickets.categories');