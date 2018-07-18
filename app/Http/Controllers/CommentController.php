<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App\Post;
use App\Category;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) 
    {
        /**
         *  Intention of this method to create comment against a particular post.
         */
        $commentObject = new Comment();
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:80',
            'email' => 'required|email|max:100',
            'message' => 'required|string|max:300',
            'postId' => 'required|integer'
        ]);
        if ($validator->fails()) {
            $commentObject->bladeStatus = 0;
            return $commentObject;
        }
        $commentObject->post_id = $request->postId;
        $commentObject->name = $request->name;
        $commentObject->email = $request->email;
        $commentObject->comment = $request->message;
        $commentObject->save();
        $post = Post::find($request->postId);
        $counter = $post->comments;
        $counter++;
        $post->comments = $counter;
        $post->update();
        $commentObject->bladeStatus = 1;
        return $commentObject;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /**
         *  Intention of this method to show all comments of a particular post.
         */
        $postObject = new Post();
        $allComments = Comment::where('post_id',$id)
        ->select('name','comment')
        ->get();
        $postCount = Post::where('id',$id)
        ->first();
        $counter = $postCount->seen;
        $counter++;
        $postCount->seen = $counter;
        $postCount->update();
        if(count($allComments) == 0) {
            $postObject->bladeStatus = 0; 
            return $postObject;   
        }
        $postObject->allComments = $allComments;
        $postObject->bladeStatus = 1;
        return $postObject;
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
