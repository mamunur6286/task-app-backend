<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use Validator;
use DB;

class CommentController extends Controller
{
    public function index (Request $request) {
        try {
             $query = Comment::with('user:id,username')->query();
            if ($request->body) {
                $query->where('body', 'LIKE', "%{$request->body}%");
            }
            $list = $query->orderBy('id', 'desc')->limit(20);
            
        } catch (\Exception $ex) {
            return response([
                'success' => false,
                'message' => 'Failed to save data.',
                'errors'  => $ex->getMessage()
            ]);
        }

        return response([
            'success' => true,
            'message' => 'Vendor list.',
            'data'    => $list
        ]);
    }
    public function store (Request $request) {

        $validator = Validator::make($request->all(), [
            'comments' => 'required',
            'posts' => 'required',
            'users' => 'required',
        ]);
        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => "Required fields are missing!",
                'errors' => $validator->errors()
            ]);
        }
        return $request->all();
        try {

            


            $model = new Comment;
            $model->user_id = $request->userId;
            $model->body = $request->body;
            $model->postId = $request->postId;
            $model->save();

            $model = new Comment;
            $model->user_id = $request->userId;
            $model->body = $request->body;
            $model->postId = $request->postId;
            $model->save();

            $model = new Comment;
            $model->user_id = $request->userId;
            $model->body = $request->body;
            $model->postId = $request->postId;
            $model->save();
            
            
        } catch (\Exception $ex) {
            return response([
                'success' => false,
                'message' => 'Failed to save data.',
                'errors'  => $ex->getMessage()
            ]);
        }

        return response([
            'success' => true,
            'message' => 'Vendor Create Successfully!',
            'data'    => $model
        ]);
    }
}
