<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostControler extends Controller
{
    public function getBlogIndex() {
        return view('frontend.blog.index');
    }

    public function getSinglePost($post_id,$end='frontend') {
        return view($end . '.blog.single');
    }

    public function getCreatePost() {
        return view('admin.blog.create_post');
    }

    public function postCreatePost(Request $request ) {
        $this->validate($request, [
            'title' => 'required|max:120|unique:posts',
            'author' => 'required|max:80',
            'body' => 'required'
            ]);

        $post = new Post();
        $post->title = $request['title'];
        $post->author = $request['author'];
        $post->body = $request['body'];
        $post->save();

        return redirect()->route('admin.index')->with(['success' => 'Post Successfully Created']);
    }
}
