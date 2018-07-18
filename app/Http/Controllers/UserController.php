<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Avatar;
use App\Post;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         *  Intention of this method to know who is at client side as per that send data at 
         *  client side. sending data from here all valid authors, all categories, all top 
         *  most blogs, all public blogs etc. 
         */
        $postObject = new PostController();
        $userPosts = new Post();
        if(Auth::user()) {
            $userAllPosts = $postObject->getUserPost();
            $userPosts->bladeStatus = 1;
            $userPosts->userPosts = $userAllPosts;
            return $userPosts;
        } else {
            /* fetching all public posts */
            $userAllPosts = DB::table('posts')
            ->join('users','posts.user_id','=','users.id')
            ->join('categories','posts.category_id','=','categories.id')
            ->select('users.id as user_id','users.first_name','users.last_name',
            'posts.*','categories.category_name')
            ->where('posts.status',1)
            ->orderBy('posts.created_at','desc')
            ->get();
            $userPosts->userPosts = $userAllPosts;
            $userPosts->bladeStatus = 0;
            /* fetching all categories and count of its uploaded blog */
            $postCategories = DB::table('categories')
             ->leftJoin('posts','categories.id','=','posts.category_id')
             ->select(DB::raw('count(posts.id) as count,categories.*'))
             ->where('posts.status',1)
             ->groupBy('categories.id')
             ->get();
             /* fetching top most blogs behalf of seen parameter */
             $topMostBlog = Post::where('status',1)
             ->orderBy('seen','desc')
             ->take(3)
             ->get();
             /* fetching valid authors data */
             $authors = DB::table('users')
             ->leftJoin('posts','users.id','=','posts.user_id')
             ->select(DB::raw('count(posts.user_id) as count,users.id,
             users.first_name,users.last_name'))
             ->where([['users.is_activated','=',1],
             ['posts.status','=',1]
             ])
             ->groupBy('users.id')
             ->orderBy('users.created_at','desc')
             ->get();
             $userPosts->postCategories = $postCategories;
             $userPosts->topMostBlog = $topMostBlog;
             $userPosts->authors = $authors;
            return $userPosts;
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
         *  Intention of this method to create new user. used laravel mailer to activate
         *  user's account. first sending email on user's email. user will be allow to login
         *  after successfully activate account by clicking on link which send my email.
         *  generating random avatar which is stored in database. it will be as per the selected
         *  gender of user.
         */
        $validator = Validator::make($request->all(),[
            'firstName' => 'required|string|max:80',
            'lastName' => 'string|max:80',
            'gender' => 'required|string|max:8',
            'email' => 'string|unique:users|max:100',
            'password' => 'required|max:80',
            'confirmPassword' => 'required|max:80|same:password'
        ]);
        if ($validator->fails()) {
            return 2;
        }
        $data = new User();
        $data->firstName = $request->firstName;
        $data->token = str_random(25);
        $data->email = $request->email;
        Mail::send('mails.userActivation',['data' => $data],function($message) use($data) {
            $message->from('inforameshgodara351@gmail.com', "WebMob-Blog");
            $message->subject("account activation e-mail");
            $message->to($data->email);
        });
        $newUser = new User();
        $avatar = Avatar::inRandomOrder()
        ->where('type',$request->gender)
        ->first();
        $newUser->first_name = $request->firstName;
        $newUser->last_name = $request->lastName;
        $newUser->gender = $request->gender;
        $newUser->email = $request->email;
        $newUser->password = bcrypt($request->password);
        $newUser->image_path = $avatar->path;
        $newUser->activation_token = $data->token;
        $newUser->save();
        return 1;
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
    public function activateUser($token) {
        /** 
         * Intention of this method to activate user's account and update account details.
         */
        $user = User::where('activation_token',$token)->first();
        if ( !is_null($user) ) {
            $user->is_activated = 1;
            $user->activation_token = '';
            $user->save();
            session()->flash('message', 'Success! Your account has been activated successfully.');
            return redirect('/');
        }
        session()->flash('message', 'Sorry! Something went wrong.');
        return redirect('/');
    }
    public function loginUser(Request $request) {
        /** 
         *  Intention of this method to login user. here is used there condition first is if user
         *  is not valid. second one is if account not activated by user. third one will be valid user.
         */
        if(Auth::attempt(['email' => $request->email,
        'password' => $request->password
        ])) {
            $user = User::where('email',$request->email)->first();
            if($user->is_activated == 1) {
                return 1;
            } else {
                Auth::logout();
                Session::flush();
                return 2;
            }
        } else {
            return 3;
        }
    }
    public function signOut() {
        /** 
         * Intention of this method to log out user 
         */
        Auth::logout();
        Session::flush();
        return 1;
    }
}
