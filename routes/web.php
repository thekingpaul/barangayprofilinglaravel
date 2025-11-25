<?php

use App\Http\Controllers\HouseHoldController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\UserController;
use App\Models\HouseHold;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (HttpRequest $request) {
    $search = $request->input('search');

    $users = User::query()
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })
        ->paginate(5)
        ->withQueryString();
    $householdsCount = HouseHold::count();
    $residentsCount = Resident::count() + HouseHold::count();

    return view('dashboard', compact('users', 'householdsCount', 'residentsCount'));
})->middleware(['auth', 'verified', 'prevent-back-history'])->name('dashboard');

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/households/prints', [HouseholdController::class, 'bulkPrint'])->name('households.bulkPrint');
    Route::resource('residents', ResidentController::class);

    Route::resource('users', UserController::class);

    Route::resource('residents', ResidentController::class);

    Route::get('/households/{household}/edit-data', [HouseHoldController::class, 'getEditData']);
    Route::get('/households/{household}/view-data', [HouseHoldController::class, 'getViewData']);

    Route::get('/residents/{resident}/edit-data', [ResidentController::class, 'getEditData'])->name('residents.getEditData');
    Route::get('/residents/{resident}/view-data', [ResidentController::class, 'getViewData'])->name('residents.getViewData');

    Route::resource('households', HouseHoldController::class);
    Route::get('/households', [HouseHoldController::class, 'index'])->name('households.index');
    Route::get('/residents', [ResidentController::class, 'index'])->name('residents.index');
    Route::post('/residents/print', [ResidentController::class, 'bulkPrint'])->name('residents.print');

});

require __DIR__.'/auth.php';
