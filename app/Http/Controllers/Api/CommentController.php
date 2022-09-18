<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use DB;
class CommentController extends Controller
{
    public function index (Request $request) {
        try {
             $query = Comment::with('user:id,username');
            if ($request->body) {
                $query->where('body', 'LIKE', "%{$request->body}%");
            }
            $list = $query->orderBy('id', 'desc')->limit(20)->get();
            
        } catch (\Exception $ex) {
            return response([
                'success' => false,
                'message' => 'Failed to save data.',
                'errors'  => $ex->getMessage()
            ]);
        }

        return response([
            'success' => true,
            'message' => 'Comment list.',
            'data'    => $list
        ]);
    }

    // insert store data
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
        
        try {
            
           $this->insertNewUser($request);
           $this->insertNewPost($request);
           $this->insertNewComment($request);

        } catch (\Exception $ex) {
            return response([
                'success' => false,
                'message' => 'Failed to save data.',
                'errors'  => $ex->getMessage()
            ]);
        }

        return response([
            'success' => true,
            'message' => 'Data Import Successfully!'
        ]);
    }


    // insert unique user here
    private function  insertNewUser ($request):void {
        $exist_ids = DB::table('users')->pluck('id')->toArray();
        $requested_ids = collect($request->users)->map(function ($user) {
            return $user['id'];
        })->toArray();
        // Insert Date
        $insertable_ids = array_values(array_diff($requested_ids, $exist_ids));
        $data = collect();
        foreach ($insertable_ids as $id) {
            $user = collect($request->users)->first(function ($user) use($id) {
                return $user['id'] == $id;
            });
            $data->push([
                'id' => $id,
                'name' => $user['username'],
                'username' => $user['username'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        DB::table('users')->insert($data->toArray());
    }

    // insert unique post here
    private function  insertNewPost ($request):void {
        $exist_ids = DB::table('posts')->pluck('id')->toArray();
        $requested_ids = collect($request->posts)->map(function ($post) {
            return $post['id'];
        })->toArray();

        // Insert Date
        $insertable_ids = array_values(array_diff($requested_ids, $exist_ids));
        $data = collect();
        foreach ($insertable_ids as $id) {
            $data->push([
                'id' => $id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        DB::table('posts')->insert($data->toArray());
    }

    private function  insertNewComment ($request):void {
        $exist_ids = DB::table('comments')->pluck('id')->toArray();
        $requested_ids = collect($request->comments)->map(function ($post) {
            return $post['id'];
        })->toArray();

        // Insert Date
        $insertable_ids = array_values(array_diff($requested_ids, $exist_ids));
        $data = collect();
        foreach ($insertable_ids as $id) {
            $comment = collect($request->comments)->first(function ($comment) use($id) {
                return $comment['id'] == $id;
            });
            $data->push([
                'id' => $id,
                'body' => $comment['body'],
                'postId' => $comment['postId'],
                'user_id' => $comment['user_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        DB::table('comments')->insert($data->toArray());
    }
}
