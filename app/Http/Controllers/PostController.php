<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

use Illuminate\Http\Request;

class PostController extends Controller
{
    // get all posts 
    public function index()
    {
        
        return response([
            'posts' => Post::orderBy('created_at', 'desc')->with('user:id,name,image')->withCount('comments', 'likes')
            ->with('likes', function ($query) {
                return  $query->where('user_id', auth()->user()->id)
                ->select('id' , 'user_id' , 'post_id')->get();
            })->get()
        ], 200);
    }
    // get single post
    public function show($id)
    {
        return response([
            'post' => Post::where('id' , $id)->withCount('comments', 'likes')->get()
        ], 200);
    }
    // create a post 
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'body' => 'required|string',

        ]);
        $image = $this->saveImage($request->image , 'posts');
        $post = Post::create([
            'body' => $attributes['body'],
            'user_id' => auth()->user()->id,
            'image' => $image
        ]);

        return response([
            'message' => 'Post Created ',
            'post' => $post,
        ],200);

    }


    
    // update a post 
    public function update(Request $request , $id)
    {
        $post = Post::find($id);
        if(!$post)
        {
            return response([
                'message' => 'Post Not Found',
            ] , 404);
        }
         if($post->user_id != auth()->user()->id)
         {
            return response([
                'message' => 'Unauthorized',
            ], 403);
         }
        $attributes = $request->validate([
            'body' => 'required|string',

        ]);
        $post->update([
            'body' => $attributes['body'],
        ]);
       

        return response([
            'message' => 'Post Updated  ',
            'post' => $post,
        ],200);

    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if(!$post)
        {
            return response([
                'message' => 'Post Not Found',
            ] , 404);
        }
         if($post->user_id != auth()->user()->id)
         {
            return response([
                'message' => 'Unauthorized',
            ], 403);
         }

         $post->comments()->delete();
         $post->likes()->delete();
         $post->delete();
         return response([
            'message' => 'Post Deleted  ',
            'post' => $post,
        ],200);

    }
}
