<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\FeedbackAnalysisService;

class FeedbackController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/analyse-feedback",
     *     summary="Analyze feedback sentiment and summary",
     *     tags={"Feedback"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"feedback_text"},
     *             @OA\Property(property="feedback_text", type="string", example="The product is great but delivery was slow.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(property="summary", type="string", example="Product good, delivery slow"),
     *             @OA\Property(property="sentiment", type="string", example="neutral")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation or logical error"
     *     )
     * )
     */
    public function analyse(Request $request, FeedbackAnalysisService $service)
    {
        // 🧩 1. Validasi dasar
        $validator = Validator::make($request->all(), [
            'feedback_text' => [
                'required',
                'string',
                'min:10',
                'max:1000',
                'regex:/[a-zA-Z]+/' // pastikan ada huruf, bukan cuma angka/simbol
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid input data.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // 🧠 2. Kirim ke service untuk analisis AI
        $result = $service->analyzeFeedback($request->feedback_text);

        // ⚙️ 3. Tangani jika AI gagal atau hasil tidak valid
        if (isset($result['error'])) {
            return response()->json([
                'message' => 'Failed to analyze feedback',
                'details' => $result,
            ], 500);
        }

        // 🚫 4. Jika hasil tidak sesuai ekspektasi (misal isinya angka doang)
        if (
            strlen($request->feedback_text) < 5 ||
            preg_match('/^\d+$/', trim($request->feedback_text))
        ) {
            return response()->json([
                'message' => 'Input feedback must contain meaningful words, not just numbers or symbols.',
            ], 422);
        }

        // ✅ 5. Jika semua oke, balikan hasil AI
        return response()->json($result);
    }
}
