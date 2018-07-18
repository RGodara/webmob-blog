@extends('layouts.app')
@section('content')
<section class="main-content-w3layouts-agileits" id="userDashboard">
  <div class="container">
      @if(Session::has('message'))
      <div class="alert alert-success">
          {{ Session::get('message') }}
      </div>
  @endif
  <h3 class="tittle" id="blogPost">Blog Posts</h3>
  <div class="row inner-sec">
    <!--left-->
    <div class="col-lg-8 left-blog-info-w3layouts-agileits text-left" v-if="postDetail==null">
      <div class="row mb-4">
        <div class="col-md-6 card my-4" v-for="(userPost, index ) in userPosts">
          <div class="card-body">
            <h5 class="card-title ">
              <span class="clickable-elements" v-on:click="getPostDetail(userPost)">@{{userPost.heading}}</span>
            </h5>
            <ul class="blog-icons my-4">
              <li>
                <a href="#">
                <i class="far fa-calendar-alt"></i> @{{userPost.created_at}}</a>
              </li>
              <li class="mx-2">
                <a href="#">
                <i class="far fa-comment"></i> @{{userPost.comments}}</a>
              </li>
              <li>
                <a href="#">
                <i class="fas fa-eye"></i> @{{userPost.seen}}</a>
              </li>
            </ul>
            <p class="card-text mb-3 blog-content">@{{userPost.description}}</p>
           <button v-on:click="getPostDetail(userPost)" class="btn btn-success read-m">Read More</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-8 left-blog-info-w3layouts-agileits text-left" v-else>
      <div class="blog-grid-top">
        <h3>
          <a href="single.html">@{{postDetail.heading}} </a>
        </h3>
        <ul class="blog-icons my-4">
          <li>
            <a href="#">
            <i class="far fa-calendar-alt"></i> @{{postDetail.created_at}}</a>
          </li>
          <li class="mx-2">
            <a href="#">
            <i class="far fa-comment"></i> @{{postDetail.comments}}</a>
          </li>
          <li>
            <a href="#">
            <i class="fas fa-eye"></i> @{{postDetail.seen}}</a>
          </li>
        </ul>
        <p>@{{postDetail.description}}
        </p>
      </div>
      <div class="comment-top" id="comments" v-if="postDetail.can_comment!=0">
        <h4>Comments</h4>
        <div class="media" v-for="(comment, index) in allComments">
          <img src="images/avatars/default.png" alt="" class="img-fluid" />
          <div class="media-body">
            <h5 class="mt-0">@{{comment.name}}</h5>
            <p>@{{comment.comment}}
            </p>
          </div>
        </div>
      </div>
      <div class="comment-top" id="leaveComment" v-if="postDetail.can_comment!=0">
        <h4>Leave a Comment</h4>
        <div class="comment-bottom">
          <form>
            <small class="error-massage" v-show="this.commentMessage.nameError != ''">@{{commentMessage.nameError}}</small>
            <input class="form-control" v-model="commentData.name" type="text" name="Name" maxlength="80" placeholder="Name" required="">
            <small class="error-massage" v-show="this.commentMessage.emailError != ''">@{{commentMessage.emailError}}</small>
            <input class="form-control" v-model="commentData.email" type="email" name="Email" maxlength="100" placeholder="Email" required="">
            <small class="error-massage" v-show="this.commentMessage.messageError != ''">@{{commentMessage.messageError}}</small>
            <textarea class="form-control" v-model="commentData.message" name="Message" maxlength="300" placeholder="Message..." required=""></textarea>
            <a href="#leaveComment" v-on:click="validateCommentData()" class="btn btn-success submit">Submit</a>
          </form>
        </div>
      </div>
    </div>
    <!--//left-->
    <!--right-->
    <aside class="col-lg-4 agileits-w3ls-right-blog-con text-left">
      <div class="right-blog-info text-left">
        <div class="tech-btm">
          <img src="images/banner1.jpg" class="card-img-top img-fluid" alt="">
        </div>
        <div class="tech-btm">
          <h4>Sign up to our newsletter</h4>
          <p>Pellentesque dui, non felis. Maecenas male </p>
          <span>
          <input type="email" placeholder="Email" required="">
          <input type="submit" value="Subscribe">
          </span>
        </div>
        <div class="tech-btm">
          <h4>Categories</h4>
          <ul class="list-group single">
            <li v-for="(category, index) in userPostCategories" v-on:click="searchBlogByCategory(category.id)" class="clickable-elements list-group-item d-flex justify-content-between align-items-center">
              @{{category.category_name}}
              <span class="badge badge-primary badge-pill">@{{category.count}}</span>
            </li>
          </ul>
        </div>
        <div class="tech-btm">
          <h4>Authors</h4>
          <ul class="list-group single">
            <li v-for="(author, index) in authors" v-on:click="searchBlogByAuther(author.id)" class="clickable-elements list-group-item d-flex justify-content-between align-items-center">
              @{{author.first_name}} @{{author.last_name}}
              <span class="badge badge-primary badge-pill">@{{author.count}}</span>
            </li>
          </ul>
        </div>
        <div class="tech-btm">
          <h4>Top most blogs</h4>
          <div v-for="(topMostBlog, index) in topMostBlog" v-on:click="getPostDetail(topMostBlog)" class="blog-grids row mb-3">
            <div class="col-md-7 blog-grid-right">
              <h5>
                <a href="#blogPost"> @{{topMostBlog.heading}} </a>
              </h5>
              <div class="sub-meta">
                <span>
                <i class="far fa-clock"></i> @{{topMostBlog.created_at}}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="tech-btm">
          <h4>Recent Posts</h4>
          <div v-for="(userPost, index ) in userPosts.slice(0,3)" v-on:click="getPostDetail(userPost)" class="blog-grids row mb-3 text-left">
            <div class="col-md-7 blog-grid-right">
              <h5>
                <a href="#blogPost"> @{{userPost.heading}} </a>
              </h5>
              <div class="sub-meta">
                <span>
                <i class="far fa-clock"></i> @{{userPost.created_at}}</span>
              </div>
            </div>
          </div>
        </div>
    </aside>
    <!--//right-->
    </div>
  </div>
</section>
@endsection