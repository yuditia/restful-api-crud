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
        $posts = Post::latest()->get();
        return response()->json([
            'success'=>true,
            'message'=>'list data posts',
            'data'=>$posts
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'content'=>'required'
        ]);

        //jika validator eror
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        //save ke database
        $post = Post::create([
            'title'=>$request->title,
            'content'=>$request->content
        ]);

        //sukses save ke db
        if($post){
            return response()->json([
                'success'=>true,
                'message'=>'data berhasil tersimpan',
                'data'=>$post
            ],201);
        }
        //jika gagal save db
        return response()->json([
            'success'=>false,
            'message'=>'data gagal tersimpan'
        ],409);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //cari id 
        $post = Post::findOrfail($id);
        //respon json
        return response()->json([
            'success'=>true,
            'message'=>'Detail data Post',
            'data'=>$post
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //membuat validasi
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'content'=>'required'
        ]);

        //response validator
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        //find post by id
        $post = Post::findOrfail($post->id);

        if($post){
            //update data
            $post->update([
                'title'=>$request->title,
                'content'=>$request->content
            ]);
            //respon jika berhasil diupdate
            return response()->json([
                'success'=>true,
                'message'=>'data berhasil diupdate',
                'data'=>$post
            ],200);
        }
        //respon gagal update
        return response()->json([
            'success'=>false,
            'message'=>'data gagal diupdate'
        ],404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrfail($id);

        if($post){
            //delet post
            $post->delete();

            return response()->json([
                'success'=>true,
                'message'=>'data berhasil dihapus',
                'data'=>$post
            ],200);
        }

        //jika gagal dipost
        return response()->json([
            'success'=>false,
            'message'=>'data gagal dihapus'
        ],404);
    }
}
