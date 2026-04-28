<?php
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommandeController;
use App\Http\Controllers\API\StaffController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\BillController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\TypeSpaSessionController;
use App\Http\Controllers\API\WorkshiftController;
use App\Http\Controllers\API\DepartementController;
use App\Http\Controllers\API\ChamberController;
use App\Http\Controllers\API\ChamberTypeController;
use App\Http\Controllers\API\SpaSessionController;
use App\Http\Controllers\API\PlatController;
use App\Http\Controllers\API\AbscenceController;
use App\Http\Controllers\API\RHController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Auth Routes */
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
});



/* Admin Routes */
/* Route::middleware(['auth:sanctum', 'role:admin'])->group(function () { */

    /* Gestion des staff */
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index']);
        Route::get('/stats', [AdminController::class, 'stats']);
        Route::get('/absences', [AdminController::class, 'absences']);
        Route::prefix('staff')->group(function () {
            Route::get('/all', [StaffController::class, 'index']);
            Route::get('/{id}', [StaffController::class, 'Show']);
            Route::post('/add', [AdminController::class, 'storeRH']);
            Route::put('/{id}/edit', [AdminController::class, 'updateRH']);
            Route::delete('/{id}/delete', [AdminController::class, 'destroy']);
        });
    });

    /* Gestion des departements */
    Route::apiResource('departements', DepartementController::class);

    /* Gestion des workshift */
    Route::apiResource('workshifts', WorkshiftController::class);

    /* Gestion des types de chambre */
    Route::apiResource('chamberTypes', ChamberTypeController::class)->except('show');

    /* Gestion des chambres */
    Route::apiResource('chambers', ChamberController::class);

    /* Gestion des services */
    ///////* --types spa sessions */
    Route::apiResource('typeSpaSession', TypeSpaSessionController::class)->except('show');
    //////* --plats */
    Route::apiResource('plats', PlatController::class);

/* }); */



    /* Gestion des absences */
    Route::apiResource('absences', AbscenceController::class);

/* RH Routes */
Route::middleware(['auth:sanctum', 'role:staff', 'departement:RH'])->group(function () {
    /* Gestion des staff */
    Route::apiResource('rh', RHController::class)->only('update');
    Route::get('rh/{id}', [RHController::class, 'storeStaff']);
});



    /* Gestion des tasks */
    Route::apiResource('tasks', TaskController::class);

/* Chef personnel Routes */
Route::middleware(['auth:sanctum', 'role:staff', 'departement:ChefPersonnel'])->group(function () {
});



    /* Gestion des spaSessions */
    Route::apiResource('spaSessions', SpaSessionController::class);

    /* Gestion des reservations */
    Route::apiResource('reservations', ReservationController::class);

    /* Gestion des commandes */
    Route::apiResource('commandes', CommandeController::class);

/* Client Routes */
Route::middleware(['auth:sanctum', 'role:client'])->group(function () {

    /* Gestion des payments */
    Route::apiResource('payments', PaymentController::class)->except('update');

    /* Gestion des bills */
    Route::apiResource('bills', BillController::class)->only('index', 'show', 'destroy');
    Route::post('bills/{commande}/store', [BillController::class, 'storeCommandeBill']);
    Route::post('bills/{spaSession}/store', [BillController::class, 'storeSpaSessionBill']);

});