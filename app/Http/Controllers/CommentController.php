<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
// use Illuminate\Support\Str;
// use App\Post;

class CommentController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'post_id' => 'required|numeric|exists:posts,id'
        ]);
        $data = $request->all();
        $newComment = new Comment;
        $newComment->fill($data);
        $saved = $newComment->save();

        if(!$saved) {
            return redirect()->back();
        }

        // dd($comment->post->slug);

        return redirect()->route('post.show', $newComment->post->slug);
    }

}
