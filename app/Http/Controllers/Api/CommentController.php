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


        
        $imgValidation = $request->file('picture') ? '' : 'nullable';
        
        $validator = Validator::make($request->all(), [
            'area_id' => 'required',
            'name' => 'required',
            'father_name' => 'required',
            'mobile' => 'required',
            'place' => 'required',
            'shop_detail' => 'required',
            'business_running_time' => 'required',
            'picture' =>  $imgValidation,
        ]);
        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => "Required fields are missing!",
                'errors' => $validator->errors()
            ]);
        }
        
        try {
            
            $model = new Vendor;
            $model->created_by = user_id();
            $model->area_id = $request->area_id;
            $model->name = $request->name;
            $model->father_name = $request->father_name;
            $model->mobile = $request->mobile;
            $model->nid_no = $request->nid_no;
            $model->blood_group = $request->blood_group;
            $model->place = $request->place;
            $model->shop_detail = $request->shop_detail;
            $model->business_running_time = $request->business_running_time;
            
            if ($request->file('picture')) {
                $imageName = time().'.'.$request->picture->extension();  
                $request->picture->move('pictures', $imageName);
                $model->picture = $imageName;
            }
            
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
