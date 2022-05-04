<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
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
        //
        $data = Post::orderBy('id','asc')->get();
        return response()->json(['tets',PostResource::collection($data)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //part app
        //check validator
        $validator = Validator::make($request->all(),[
            'title'  =>  'required|string',   //จำเป็นต้องมีเเละเป็น string
            'desc'  =>  'string',
        ]);

        //if validator fail
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $data = Post::create([
            'title'  => $request->title,
            'desc'  => $request->desc,
        ]);

        return response()->json(['Post Created successfully!', new PostResource($data)]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
         //check validator
         $validator = Validator::make($request->all(),[
            'title'  =>  'required|string',   //จำเป็นต้องมีเเละเป็น string
            'desc'  =>  'string|nullable',
        ]);

        //if validator fail
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $post->title=$request->title;
        $post->desc=$request->desc;
        $post->save();

        return response()->json(['Post updated successfully!', new PostResource($post)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();
        return response()->json(['Post deleted successfully!', $post]);
    }
}
