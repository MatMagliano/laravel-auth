<?php

namespace App\Http\Controllers\Admin;
use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        
        return view('admin.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('admin.create', compact('tags'));
    }

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
        ]);
        $data = $request->all();
        $newPost = new Post;
        $newPost->fill($data);
        $newPost->user_id = Auth::id();
        $newPost->slug = Str::finish(Str::slug($newPost->title),rand(1, 1000000));
        $saved = $newPost->save();
        if(!$saved) {
            return redirect()->back();
        }

        $tags = $data['tags'];
        if(!empty($tags)) {
            $newPost->tags()->attach($tags);
        }



        return redirect()->route('admin.posts.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('Admin.show', compact('post'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        $data = [
            'tags' => $tags,
            'post' => $post,
        ];
        return view('Admin.edit', $data);
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
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
        ]);
        $data = $request->all();
        $post->user_id = Auth::id();
        $post->slug = Str::finish(Str::slug($post->title),rand(1, 1000000));

        $updated = $post->update($data);
        if (!$updated) {
            return redirect()->back();
        }
        $tags = $data['tags'];
        if(!empty($tags)) {
            $post->tags()->sync($tags);
        }

        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (empty($post)) {
            abort('404');
        }
        $post->comments()->delete();
        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.posts.index');
        
    }
}
