<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;

Route::post('/analyse-feedback', [FeedbackController::class, 'analyse']);
