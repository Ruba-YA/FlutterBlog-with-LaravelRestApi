<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // get all commenst 
    public function index($id)
    {
        $post = Post::find($id);
        if(!$post)
        {
            return response([
                'message' => 'Post Not Found',
            ] , 404);
        }

        return response([
            'comment' => $post->comments()->with('user:id,name,image')->get()
        ], 200);
       
    }


    // CREATE A COMMENT

    public function store(Request $request , $id)
    {
        $post = Post::find($id);
        if(!$post)
        {
            return response([
                'message' => 'Post Not Found',
            ] , 404);
        }

        $attributes = $request->validate([
            'comment' => 'required|string',

        ]);
        Comment::create([
            'comment' => $attributes['comment'],
            'user_id' => auth()->user()->id,
            'post_id' => $id
        ]);

        return response([
            
            'message' => 'Comment created successfully',
        ],200);

    }

    // UPDATE A COMMENT
    public function update(Request $request , $id)
    {
        $comment = Comment::find($id);
        if(!$comment)
        {
            return response([
                'message' => 'Comment Not Found',
            ] , 404);
        }
        if($comment->user_id != auth()->user()->id)
        {
            return response([
                'message' => 'Unauthorized',
            ], 403);
        }

        $attributes = $request->validate([
            'comment' => 'required|string',
        ]);
        $comment->update([
            'comment' => $attributes['comment'],
        ]);

        return response([
            'message' => 'Comment Updated  ',
            'comment' => $comment,
        ],200);
        
    }

    // DELETE A COMMENT
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if(!$comment)
        {
            return response([
                'message' => 'Comment Not Found',
            ] , 404);
        }
        if($comment->user_id != auth()->user()->id)
        {
            return response([
                'message' => 'Unauthorized',
            ], 403);
        }
        $comment->delete();
        return response([
            'message' => 'Comment deleted successfully',
        ],200);
    }
}
