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
Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {

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

    /* Gestion des tasks */
    Route::get('/tasks', [TaskController::class, 'index']);

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

    /* Gestion des spaSessions */
    Route::apiResource('spaSessions', SpaSessionController::class);

});


/* Staff Routes */
Route::prefix('staff')->middleware(['auth:sanctum', 'role:staff'])->group(function () {
    /* Gestion des departements */
    Route::get('departements/{id}', [DepartementController::class, 'show']);
    /* Gestion des stats */
    Route::get('stats', [AdminController::class, 'stats']);
    /* Gestion des tasks */
    Route::get('tasks', [TaskController::class, 'index']);
    /* Gestion des absences */
    Route::get('absences', [AbscenceController::class, 'index']);
    
    /* RH Routes */
    Route::prefix('rh')->middleware(['departement:RH'])->group(function () {
        /* Gestion des stats */
        Route::get('stats', [AdminController::class, 'stats']);
        /* Gestion des tasks */
        Route::get('tasks', [TaskController::class, 'index']);
        /* Gestion des absences */
        Route::apiResource('absences', AbscenceController::class);
        /* Gestion des workshift */
        Route::get('workshifts', [WorkshiftController::class, 'index']);
        /* Gestion des departements */
        Route::get('departements', [DepartementController::class, 'index']);
        Route::get('departements/{id}', [DepartementController::class, 'show']);
        /* Gestion des staff */
        Route::prefix('staff')->group(function () {
            Route::get('/all', [StaffController::class, 'index']);
            Route::get('/{id}', [StaffController::class, 'Show']);
            Route::post('/add', [AdminController::class, 'storeRH']);
            Route::put('/{id}/edit', [AdminController::class, 'updateRH']);
            Route::delete('/{id}/delete', [AdminController::class, 'destroy']);
        });
        /* Gestion des staff */
        Route::apiResource('', RHController::class)->only('update');
        Route::get('{id}', [RHController::class, 'storeStaff']);
    });

    /* Chef personnel Routes */
    Route::prefix('chef')->middleware(['departement:ChefPersonnel'])->group(function () {
        /* Gestion des tasks */
        Route::apiResource('tasks', TaskController::class);
        /* Gestion des stats */
        Route::get('stats', [AdminController::class, 'stats']);
        /* Gestion des absences */
        Route::get('absences', [AbscenceController::class, 'index']);
        /* Gestion des departements */
        Route::get('departements', [DepartementController::class, 'index']);
        Route::get('departements/{id}', [DepartementController::class, 'show']);
    });
});



/* Client Routes */
Route::prefix('client')->middleware(['auth:sanctum', 'role:client'])->group(function () {

    /* Gestion des payments */
    Route::apiResource('payments', PaymentController::class)->except('update');

    /* Gestion des bills */
    Route::apiResource('bills', BillController::class)->only('index', 'show', 'destroy');
    Route::post('bills/{commande}/store', [BillController::class, 'storeCommandeBill']);
    Route::post('bills/{spaSession}/store', [BillController::class, 'storeSpaSessionBill']);

    /* Gestion des spaSessions */
    Route::apiResource('spaSessions', SpaSessionController::class);

    /* Gestion des reservations */
    Route::apiResource('reservations', ReservationController::class);

    /* Gestion des commandes */
    Route::apiResource('commandes', CommandeController::class);

    Route::withoutMiddleware(['auth:sanctum', 'role:client'])->group(function () {
        /* Gestion des plats */
        Route::get('plats', [PlatController::class, 'index']);

        /* Gestion des chambres */
        Route::get('chambers', [ChamberController::class, 'index']);

        /* Gestion des types de spa sessions */
        Route::get('typeSpaSession', [TypeSpaSessionController::class, 'index']);
    });

});