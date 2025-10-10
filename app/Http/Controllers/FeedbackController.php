<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FeedbackAnalysisService;

class FeedbackController extends Controller
{
    public function analyse(Request $request, FeedbackAnalysisService $service)
    {
        $feedbackText = $request->input('feedback_text');

        if (!$feedbackText) {
            return response()->json(['error' => 'feedback_text is required'], 400);
        }

        // 🔥 Sekarang panggil service beneran
        $result = $service->analyzeFeedback($feedbackText);

        return response()->json($result);
    }
}
