<?php

// Merge these route declarations into routes/web.php inside the existing auth middleware group.
// The attachments route must be available to authenticated users; student routes are role protected.
use App\Http\Controllers\ComplaintController;
use Illuminate\Support\Facades\Route;

Route::get('/attachments/{attachment}', [ComplaintController::class, 'downloadAttachment'])
    ->name('attachments.download');

Route::middleware('role:student')->group(function () {
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
});
