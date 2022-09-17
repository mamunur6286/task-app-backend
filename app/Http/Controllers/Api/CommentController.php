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


            // first get ids from table
$exist_ids = DB::table('shipping_costs')->pluck('area_id')->toArray();
// get requested ids
$requested_ids = $request->get('area_ids');
// get updatable ids
$updatable_ids = array_values(array_intersect($exist_ids, $requested_ids));
// get insertable ids
$insertable_ids = array_values(array_diff($requested_ids, $exist_ids));
// prepare data for insert
$data = collect();
foreach ($insertable_ids as $id) {
$data->push([
    'area_id' => $id,
    'cost' => $request->get('cost'),
    'created_at' => now(),
    'updated_at' => now()
]);
}
DB::table('shipping_costs')->insert($data->toArray());

// prepare for update
DB::table('shipping_costs')
->whereIn('area_id', $updatable_ids)
->update([
    'cost' => $request->get('cost'),
    'updated_at' => now()
]);


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
