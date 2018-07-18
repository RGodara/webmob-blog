<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         *  Intention of this method to fetch data as per who is at client side.
         *  sending data user's category and count of uploaded total blogs.
         *  sending all categories also to show categories while uploading blog
         *  in blog from as drop down list.
         */
        $userObject = new User();
        if(Auth::User()) {
             $user = Auth::User();
             $userObject->name = $user->first_name;
             $userObject->imagePath = $user->image_path;
             $userObject->bladeStatus = 1;
             $allCategories = Category::all();
             $userPostCategories = DB::table('categories')
             ->leftJoin('posts','categories.id','=','posts.category_id')
             ->leftJoin('users','posts.user_id','=','users.id')
             ->select(DB::raw('count(posts.id) as count,categories.*'))
             ->where('posts.user_id',Auth::user()->id)
             ->groupBy('categories.id')
             ->get();
             foreach($allCategories as $categoryKey => $categoryValue) {
                 $categoryValue->value = $categoryValue->id;    
                 $categoryValue->text = $categoryValue->category_name;
             }
             $userObject->allCategories = $allCategories;
             $userObject->userPostCategories = $userPostCategories;
             return $userObject;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /**
         *  Intention of this method to create new post of user.
         */
        $postObject = new Post();
        $validator = Validator::make($request->all(),[
            'heading' => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'status' => 'required|string|max:10',
            'canComment' => 'required|string|max:10',
            'id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            $postObject->bladeStatus = 2;
            return $postObject;
        }
        $canComment = "";
        $status = "";
        if($request->canComment == "yes") {
            $canComment = 1;
        } else {
            $canComment = 0;
        }
        if($request->status == "public") {
            $status = 1;
        } else {
            $status = 0;
        }
        $userId = Auth::user()->id;
        $userPost = new Post();
        $userPost->heading = $request->heading;
        $userPost->user_id = $userId;
        $userPost->description = $request->description;
        $userPost->status = $status;
        $userPost->can_comment = $canComment;
        $userPost->category_id = $request->id;
        $userPost->save();
        $postObject->bladeStatus = 1;
        $userPost = $this->getUserPost();
        $postObject->userPosts = $userPost;
        return $postObject;
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
        //
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
    public function getUserPost() {
        /**
         *  Intention of this method to get user's posts.
         */
        $userPosts = Post::where('user_id',Auth::user()->id)
        ->orderBy('created_at','desc')
        ->get();
        return $userPosts;
    }
}
