<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(){
        $posts=Post::all();
        $postresource=PostResource::collection($posts);
        return response()->json(["data"=>$postresource],200);
    }
    public function show(){
        $post = Post::find(request()->post);
        
        if(is_null($post)){
            return response()->json(["Error"=>"No such a post with this id"],404);
        }
        return response()->json(["data"=> new PostResource($post)],200);
    }

    public function myPosts($user_id){
        $post = Post::where('user_id',$user_id)->get();
        $postresource=PostResource::collection($post);

        if(!count($post)){
            return response()->json(["Error"=>"No such a post with this id"],404);
        }
        return response()->json(["data"=> $postresource],200);
    }

    public function store(request $request){

        $post = Post::create([
            'hashtag'=>$request->hashtag ,
            'content'=>$request->content,
            'user_id'=>$request->user_id ,
        ]);
   
        if($post)
        {
            return response()->json([
                "Success" => 'The post was added',
                "Data:"=> new PostResource($post),],200);
        }
        if(!$post){
            return response()->json(["Error"=>"Post was not added due to an error"],404);
        }
    }


    public function update(Request $request, $postId){ 
        $post = Post::find($postId);
        if(is_null($post)){
            return response()->json(["Error"=>"Record doesn't found in the datatabase!! Enter a valid id ^_^"],404);
        }
       
        
        $post->update([
            'hashtag'=>$request->hashtag ,
            'content'=>$request->content,
            'user_id'=>$request->user_id ,
        ]);
       
        return response()->json(["Success"=>"Post is Updated",
                                    "New data:"=> new PostResource($post)],200);
    }
}
