<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
public function index()
{
    $post = Post::all();
    return response()->json(['success'=>true,'data'=>['post' => $post]],200);
}

public function create()
{
    return view('posts.create');
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'content' => 'required',
    ]);
    
    $post = Post::create($request->all());

    return response()->json(['success'=>true,'data'=>['post' => $post]],200);
}

public function show($id)
{

    $post = Post::Find($id);
    return response()->json(['success'=>true,'data'=>['post' => $post]],200);
}

public function edit(Post $post)
{
    return view('posts.edit', compact('post'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'content' => 'required',
    ]);
    
    $post = Post::Find($id);

    $post->title=$request->title;
    $post->content=$request->content;
    $post->update();

    return response()->json(['success'=>true,'data'=>['post' => $post]],200);
}

public function destroy($id)
{

    $post = Post::Find($id);
    $post->delete();
    
    return response()->json(['success'=>true, 'message'=> "success delete"],200);
}
}
