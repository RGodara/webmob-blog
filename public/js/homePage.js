/**
 *  This is file is used to manipulate data between server and client of webmob blog.
 *  These four lives of the code have been used to show process loader till response 
 *  does not come from the server.
 */
$(document).ajaxStart(function () {
    $("#loading").show();
}).ajaxStop(function () {
    $("#loading").hide();
});
jQuery(document).ready(function($) {    
    var homePage = new Vue({
      el: '#homePage',
      data: {
        userRegistrationData : {
        firstName : '',   
        lastName :  '',
        gender : '',
        email : '',
        password : '',
        confirmPassword : '',
        },
        userRegMessages : {
            firstNameError : '',
            lastNameError : '',
            genderError : '',
            emailError : '',
            passwordError : '',
            confirmPasswordError : '',
            passwordDoesNotMatch : '',
            serverErrorMessage : '',
            successMessage : '',
        },
        userLoginData : {
            email : '',
            password : '',
        },
        userLoginMessages : {
            emailError : '',
            passwordError : '',
            serverError : '',
            serverSuccess : '',
        },
        userType : 'guest',
        userNewPost : {
            id : 0,
            heading : '',
            categoryId : '',
            description : '',
            status : 'public',
            canComment : 'yes'
        },
        userBlogMessages : {
            headingError : '',
            descriptionError : '',
            categoryError : '',
            successMessage : '',
            serverError : '',
        },
        commentData : {
            name : '',
            email : '',
            message : ''
        },
        commentMessage : {
            postId : '',
            nameError : '',
            emailError : '',
            messageError : ''
        },
        allCategories : [],
        userPostCategories : [],
        userPosts : [],
        tempUserPosts : [],
        onLoadUsersPosts : [],
        topMostBlog : [],
        authors : [],
        searchText : '',
        postDetail : null,
        allComments : []
      },
      methods: {
        registerUser: function() {
        /**
         *  Intention of this method to register user. in this method some parameters have been
         *  used for error purpose. like 2 is if server side validation fails. used ajax request
         *  to transfer data from client.
         */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'POST',
            url: '/registerUser',
            data: this.userRegistrationData ,
            success:function(data){
                if(data == 2) {
                    homePage.userRegMessages.serverErrorMessage = 'Something went wrong either email already exists or data does not filled up properly';
                } else {
                    $('#registrationModal').modal('toggle');
                    $('#loginModal').modal('toggle');
                    homePage.userRegistrationData.firstName = '';
                    homePage.userRegistrationData.lastName = '';
                    homePage.userRegistrationData.gender = '';
                    homePage.userRegistrationData.password = '';
                    homePage.userRegistrationData.confirmPassword = '';
                    homePage.userRegistrationData.email = '';
                    homePage.userRegMessages.confirmPasswordError = '';
                    homePage.userRegMessages.emailError = '';
                    homePage.userRegMessages.firstNameError = '';
                    homePage.userRegMessages.genderError = '';
                    homePage.userRegMessages.lastNameError = ''
                    homePage.userRegMessages.passwordDoesNotMatch = '';
                    homePage.userRegMessages.passwordError = '';
                    homePage.userRegMessages.serverErrorMessage = '';
                    homePage.userRegMessages.successMessage = 'Thank you! We sent you a confirmation email with a link to activate your account. Please check your email and click the link.';
                }
            },
            error:function(){
                alert('Something went wrong!');
            }
        });
        },
        loginUser:function() {
            /**
             *  Intention of this method to login user into his/her dashboard so user can easily
             *  upload blog and can see uploaded blogs. used ajax request to transfer data.
             */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url: '/loginUser',
                data: this.userLoginData ,
                success:function(data){
                    if(data == 1) {
                        $('#loginModal').modal('toggle');
                        $('.modal-backdrop').remove();
                        homePage.userType = "user";
                        window.location.replace("/userDashboard");
                        //homePage.userLoginMessages.successMessage = '';
                    } else if(data == 2) {
                        homePage.userRegMessages.successMessage = '';
                        homePage.userLoginMessages.serverError = 'Your account is not activated. please activate your account.';
                    } else if(data == 3) {
                        homePage.userRegMessages.successMessage = '';
                        homePage.userLoginMessages.serverError = 'Sorry! Invalid credentials. please try again.';
                    } else {
                        alert('Something went wrong');
                    }
                },
                error:function(){
                    //alert('Something went wrong!');
                }
            });
        },
        validateRegistrationForm: function () {
            /**
             *  Intention of this method to validate user registration form at client side before
             *  uploading data on server. 
             */
            if(!this.userRegistrationData.firstName || !this.userRegistrationData.lastName || 
                !this.userRegistrationData.email || !this.userRegistrationData.password ||
                !this.userRegistrationData.confirmPassword || !this.userRegistrationData.gender || 
                (this.userRegistrationData.password != this.userRegistrationData.confirmPassword)) {
            if(!this.userRegistrationData.firstName) {
                this.userRegMessages.firstNameError = 'First name is required.';
            } else {
                this.userRegMessages.firstNameError = '';
            }
            if(!this.userRegistrationData.lastName) {
                this.userRegMessages.lastNameError = 'Last name is required.';
            } else {
                this.userRegMessages.lastNameError = '';
            }
            if(!this.userRegistrationData.email) {
                this.userRegMessages.emailError = 'E-mail is required.';
            } else {
                this.userRegMessages.emailError = '';
            }
            if(!this.userRegistrationData.password) {
                this.userRegMessages.passwordError = 'Password is required.';
            } else {
                this.userRegMessages.passwordError = '';
            }
            if(!this.userRegistrationData.confirmPassword) {
                this.userRegMessages.confirmPasswordError = 'Confirm password is required.';
            } else {
                this.userRegMessages.confirmPasswordError = '';
            }
            if(!this.userRegistrationData.gender) {
                this.userRegMessages.genderError = 'Gender is required.';
            } else {
                this.userRegMessages.genderError = '';
            }
            if(this.userRegistrationData.password != "" && this.userRegistrationData.confirmPassword != "") {
                if(this.userRegistrationData.password != this.userRegistrationData.confirmPassword) {
                    this.userRegMessages.passwordDoesNotMatch = "Password does not match.";
                } else {
                    this.userRegMessages.passwordDoesNotMatch = '';
                }
            }  
        } else {
            /* if user filled up form properly then call registerUser method */
            this.registerUser();   
        }
        },
        getHomeScreen: function() {
            /**
             *  Intention of this method to know who is at client side user or guest. means if user
             *  logged in and after some time he refreshed page then where we have to land functionality.
             */
            $.ajax({
                type:'get',
                url: '/getHomeScreen',
                success:function(data){
                    if(data.bladeStatus == 1) {
                        homePage.userType = "user";
                        homePage.userPosts = data.userPosts;
                        homePage.onLoadUsersPosts = data.userPosts;
                    } else if(data.bladeStatus == 0) {
                        homePage.userType = "guest";
                        homePage.userPosts = data.userPosts;
                        homePage.onLoadUsersPosts = data.userPosts;
                        homePage.userPostCategories = data.postCategories;
                        homePage.topMostBlog = data.topMostBlog;
                        homePage.authors = data.authors;
                    } else {
                        // alert('Something went wrong');
                    }
                },
                error:function(){
                    // alert('Something went wrong!');
                }
            });
        },
        validateLoginForm: function() {     
            /**
             *  Intention of this method to validate login form before uploading data on server.
             */
            if(!this.userLoginData.email || !this.userLoginData.password) {
                if(!this.userLoginData.email) {
                    this.userLoginMessages.emailError = 'E-mail is required.';
                } else {
                    this.userLoginMessages.emailError = '';
                }
                if(!this.userLoginData.password) {
                    this.userLoginMessages.passwordError = 'Password is required.';
                } else {
                    this.userLoginMessages.passwordError = '';
                }
            } else {
                /* if login form validated then call loginUser() */
                this.loginUser();
            }
        },
        validateBlogData:function() {
            /**
             *  Intention of this method to validate add blog form at client side before uploading
             *  data on server. 
             */
            if(!this.userNewPost.heading || !this.userNewPost.description ||
             !this.userNewPost.categoryId) {
                if(!this.userNewPost.heading) {
                    this.userBlogMessages.headingError = 'Heading is required.';
                } else {
                    this.userBlogMessages.headingError = '';
                }
                if(!this.userNewPost.description) {
                    this.userBlogMessages.descriptionError = 'Description is required.';
                } else {
                    this.userBlogMessages.descriptionError = '';
                }
                if(!this.userNewPost.categoryId) {
                    this.userBlogMessages.categoryError = 'Category is required.';
                } else {
                    this.userBlogMessages.categoryError = '';
                }
            } else {
                /* if add blog form validated successfully */
                this.uploadBlog();
            }
        },
        
        getPosts:function() {
            /** 
             *  Intention of this method to get posts and user data from server in user's dashboard.
             */
            $.ajax({
                type:'get',
                url: '/getPosts',
                success:function(data){
                    if(data.bladeStatus == 1) {
                        $('#welcome').html(data.name);
                        $('#userProfile').prepend('<img style="width:10%;border-radius: 50%;" src="'+data.imagePath+'" />');
                        homePage.allCategories = data.allCategories;
                        homePage.userPostCategories = data.userPostCategories;
                    } else {
                        // alert('Something went wrong');
                    }
                },
                error:function(){
                    // alert('Something went wrong!');
                }
            });
        },
        getIdOfCategory:function () {
            /**
             *  Intention of this method to get category id from allCategories array of object.
             *  Directly Vue js does not support with select if data fetched from database. 
             *  so have used this solution.
             */
            var values = this.allCategories.map(function(o) { return o.text })
            var index = values.indexOf(this.userNewPost.categoryId)
            this.userNewPost.id = this.allCategories[index].value; 
        },
        displayModel:function() {

            $('addBlogModal').css('display','bloack');
        },
        uploadBlog:function() {
            /** 
             *  Intention of this method to upload blog on server. used ajax request to upload data on server.
             */
            this.postDetail=null;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url: '/uploadBlog',
                data: this.userNewPost,
                success:function(data){
                    if(data.bladeStatus == 1) {
                        /* resetting data of blog form */
                        homePage.userNewPost.id = 0;
                        homePage.userNewPost.heading = '';
                        homePage.userNewPost.description = '';
                        homePage.userNewPost.status = 'public';
                        homePage.userNewPost.canComment = 'yes';
                        homePage.userNewPost.seen = 0;
                        homePage.userNewPost.comments = 0;
                        homePage.userNewPost.likes = 0;
                        homePage.userBlogMessages.successMessage = '';
                        homePage.userPosts = data.userPosts;
                        homePage.userBlogMessages.successMessage = ' Your blog has been added successfully.';
                    } else {
                        homePage.userBlogMessages.serverError = ' Something went wrong. not entered proper data. please try again.';
                    }
                },
                error:function(){
                    alert('Something went wrong!');
                }
            });
        },
        searchBlogByAuther:function(authorId) {
            /**
             *  Intention of this method to search blog by clicking on author name at the right side
             *  of the welcome page. 
             */
            this.postDetail=null;
            this.tempUserPosts = [];
            this.searchText = '';
            /* Iterating posts onLoadUsersPosts */
            for(var counter in this.onLoadUsersPosts) {
                if(this.onLoadUsersPosts[counter].user_id == authorId) {
                    this.tempUserPosts.push(this.onLoadUsersPosts[counter]);
                }
            }
            this.userPosts = this.tempUserPosts;
            window.location.replace("#blogPost");
        },
        searchBlogByCategory:function(categoryId) {
            /**
             *  Intention of this method to search blogs by clicking on category at the rght 
             *  side of welcome page.
             */
            this.postDetail=null;
            this.tempUserPosts = [];
            this.searchText = '';
            /* Iterating posts onLoadUsersPosts */
            for(var counter in this.onLoadUsersPosts) {
                if(this.onLoadUsersPosts[counter].category_id == categoryId) {
                    this.tempUserPosts.push(this.onLoadUsersPosts[counter]);
                }
            }
            this.userPosts = this.tempUserPosts;
            window.location.replace("#blogPost");
        },
        searchBlogByKeyWords:function() {
            /**
             *  Intention of this method to search blog by author name or category name.
             *  this method will be execute on key press in search box which is at top of 
             *  welcome page.
             */
            this.postDetail=null;
            var searchText = this.searchText.toLowerCase();
            this.userPosts = this.onLoadUsersPosts.filter(element =>
                element['first_name'].toLowerCase().indexOf(searchText) >= 0 ||
                element['category_name'].toLowerCase().indexOf(searchText) >= 0
            );
        },
        getPostDetail:function(userPost) {
            /** 
             *  Intention of this method to get post and its comments by clicking either heading
             *  of post or "Read More" button.
             */
            this.postDetail =  userPost;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'get',
                url: '/getPostDetail/'+this.postDetail.id,
                success:function(data){
                    if(data.bladeStatus == 1) {
                        homePage.allComments = data.allComments;
                    }  else {
                    }
                },
                error:function(){
                    alert('Something went wrong!');
                }
            });
        },
        validateCommentData:function() {
            /** 
             *  Intention of this method to validate comment form data. if it validated
             *  successfully then it will be call method to proceed upload comment on server.
             */
            if(!this.commentData.name || !this.commentData.email || !this.commentData.message) {
                if(!this.commentData.name) {
                    this.commentMessage.nameError = 'Name is required.';
                } else {
                    this.commentMessage.nameError = '';
                }
                if(!this.commentData.email) {
                    this.commentMessage.emailError = 'E-mail is required.'; 
                } else {
                    this.commentMessage.emailError = '';
                }
                if(!this.commentData.message) {
                    this.commentMessage.messageError = 'Message is required.';
                } else {
                    this.commentMessage.messageError = '';
                }
            } else {
                this.commentData.postId = this.postDetail.id;
                this.uploadComment();
            }
        },
        uploadComment:function() {
            /** 
             *  Intention of this method to upload comment on server.
             */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url: '/uploadComment',
                data: this.commentData ,
                success:function(data){
                    if(data.bladeStatus == 1) {
                        homePage.getPostDetail(homePage.postDetail);
                        window.location.replace("#comments");
                        homePage.commentData.name = '';
                        homePage.commentData.email = '';
                        homePage.commentData.message = '';
                    }  else {
                        alert('Something went wrong');
                    }
                },
                error:function(){
                }
            });  
        },
        signOut : function() {
            /**
             *  Intention of this method to log out user.
             */
            $.ajax({
                type:'get',
                url: '/signOut',
                success:function(data){
                    if(data == 1) {
                        homePage.userType = "guest";
                        window.location.replace("/");
                    } else {
                        alert('Something went wrong');
                    }
                },
                error:function(){
                    alert('Something went wrong!');
                }
            });
        }
      }
    })
    homePage.getHomeScreen();
    homePage.getPosts();
  });