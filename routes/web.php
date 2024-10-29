<?php

use App\Http\Controllers\ProfileController;
use App\Models\Consumable;
use App\Models\Date;
use App\Models\Event;
use App\Models\Quote;
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

Route::get('/', function () {

    $quotes = Quote::paginate(4);
    $consumables = Consumable::all();
    $events = Event::all();
    $fullQuoteDates = Quote::selectRaw('date, count(*) as count')
        ->groupBy('date')
        ->having('count', '>=', 3)
        ->pluck('date');
    return view('pages.dashboard', compact('quotes', 'consumables', 'events', 'fullQuoteDates'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/*
require __DIR__.'/auth.php';

*/
