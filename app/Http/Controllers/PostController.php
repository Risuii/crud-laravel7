<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
public function index()
{
    try {
        $post = Post::all();
        return response()->json(['success'=>true,'data'=>['post' => $post]],200);
    } catch(\Exception $e) {
        return response()->json(['success'=>false,'data'=>"{}",'message'=>"Failed Create ".$e->getMessage()],500);
    }
}

public function store(Request $request)
{
    try {
        $data = Post::where('title', $request->title)->first();

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'unique:posts'],
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => "{}",
                'message' => $validator->errors(),
                'request' => $request->all()
            ], 400);
        }
        
        if ($data) {
            return response()->json([
                'success' => false,
                'data' => "{}",
                'message' => 'Judul postingan sudah digunakan.',
                'request' => $request->all()
            ], 400);
        }
        
        $post = Post::create($request->all());
        
        return response()->json([
            'success' => true,
            'data' => ['post' => $post]
        ], 200);
    } catch (\Exception $e){
        return response()->json(['success'=>false,'data'=>"{}",'message'=>"Failed Create ".$e->getMessage(),'request'=>$request->all()],500);
    }
}

public function show($id)
{
    try {
    $data = Post::Find($id);

    if(!$data) {
        return response()->json([
            'success' => false,
            'message' => 'Not Found',
        ], 400);
    }

    return response()->json(['success'=>true,'data'=>['post' => $data]],200);
    } catch(\Exception $e) {
        return response()->json(['success'=>false,'data'=>"{}",'message'=>"Failed Create ".$e->getMessage(),'request'=>$id->all()],500);
    }
}

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'content' => 'required',
    ]);
    
    $data = Post::Find($id);

    if(!$data) {
        return response()->json([
            'success' => false,
            'message' => 'Not Found',
        ], 400);
    }

    $data->title=$request->title;
    $data->content=$request->content;
    $data->update();

    return response()->json(['success'=>true,'data'=>['post' => $data]],200);
}

public function destroy($id)
{
    try {
        $data = Post::Find($id);
        $data->delete();
        return response()->json(['success'=>true, 'message'=> "success delete"],200);
    } catch(\Exception $e) {
        return response()->json(['success'=>false,'data'=>"{}",'message'=>"Failed Create ".$e->getMessage()],500);
    }  
}
}
