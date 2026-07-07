<?php

namespace App\Http\Controllers;

use App\Services\MemoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemoryCommentController extends Controller
{
    /**
     * POST /api/memory-comments — add a new comment to a /memorize timeline post.
     */
    public function store(Request $request, MemoryRepository $memories)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:1000'],
        ], [
            'post_id.required' => 'Thiếu thông tin bài viết.',
            'name.required' => 'Vui lòng nhập tên của bạn.',
            'message.required' => 'Vui lòng nhập nội dung bình luận.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 400);
        }

        $data = $validator->validated();

        $newComment = $memories->addComment($data['post_id'], [
            'name' => trim($data['name']),
            'message' => trim($data['message']),
            'ip_address' => $request->ip() ?? '',
            'user_agent' => substr($request->userAgent() ?? '', 0, 255),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã đăng bình luận.',
            'data' => $newComment,
        ]);
    }
}
