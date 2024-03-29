<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventsController;
use App\Http\Controllers\QrCodeController;



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
   /// return view('welcome');
   return redirect('/login');
});
// Route::get('/Asfar', function () {
//     return view("Asfar");
// });






Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //qr code library 
    Route::get('/qrcode', [QrCodeController::class, 'index']);

    Route::post('/event-save', [EventsController::class, 'store'])->name('event.store');
    Route::get('/add-event/{id?}', [EventsController::class, 'addEvent'])->name('event.add');
    //Route::get('/events/first/edit', [EventController::class, 'editFirst'])->name('events.edit');
    Route::get('/get-all-events', [EventsController::class, 'getAllEvents'])->name('get.all.events');
    Route::get('/view-events', [EventsController::class, 'viewEvents'])->name('viewEvents');
    Route::get('/get-all-candidates', [EventsController::class, 'getAllCandidates'])->name('get.all.candidates');
    Route::get('/view-candidates/{event_id}', [EventsController::class, 'viewCandidates'])->name('viewCandidates');
    Route::get('/candidates/{id?}', [EventsController::class, 'eventCandidates'])->name('event.candidates');
    Route::post('/generate-qr-code', [EventsController::class, 'generateQRCode'])->name('generate.qr.code');
    Route::get('/logout', [ProfileController::class, 'destroy'])->name('get.destroy');
    Route::get('/download-resume/{id}', [EventsController::class, 'downloadResume'])->name('downloadResume');
});


require __DIR__.'/auth.php';