<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Like or Unlike a post
    public function likeOrUnlike(Request $request , $id)
    {
        $post = Post::find($id);
        if(!$post)
        {
            return response([
                'message' => 'Post Not Found',
            ] , 404);
        }

        $like = $post->likes()->where('user_id' , auth()->user()->id)->first();
        if(!$like)
        {
            Like::create([
                'user_id' => auth()->user()->id,
                'post_id' => $id,
            ]);
            return response([
                'message' => 'Post Liked',
            ] , 200);
        }
        //else dislike it
        $like->delete();
        return response([
            'message' => 'Disliked',
        ] , 200);

    }
}
