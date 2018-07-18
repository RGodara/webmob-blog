@extends('layouts.app')
@section('content')
<section class="main-content-w3layouts-agileits" id="userDashboard">
  <div class="modal fade" id="addBlogModal" tabindex="-1" role="dialog" aria-labelledby="addBlogModal" aria-hidden="true">
    <div class="modal-dialog modal-content">
      <div>
        <div class="login p-5 bg-light mx-auto mw-100">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="success-message" v-show="this.userBlogMessages.successMessage != ''"><strong>Success!</strong> @{{userBlogMessages.successMessage}}</div>
          <small class="error-massage" v-show="this.userBlogMessages.serverError != ''"><strong>Sorry!</strong> @{{userBlogMessages.serverError}}</small>
          <form>
            <div class="form-group">
              <label for="exampleInputHeading mb-2">Heading<span class="error-massage">*</span></label>
              <input type="text" class="form-control" v-model="userNewPost.heading" maxlength="200" aria-describedby="headingHelp" placeholder="Please enter heading of blog">
              <small class="error-massage" v-show="this.userBlogMessages.headingError != ''">@{{userBlogMessages.headingError}}</small>
            </div>
            <div class="form-group">
              <label for="exampleInputDescription mb-2">Cagegories<span class="error-massage">*</span></label>
              <select class="form-control" id="sel1" size v-on:change="getIdOfCategory" v-model="userNewPost.categoryId">
                <option v-for="(category, index) in allCategories" >@{{category.category_name}}</option>
              </select>
              <small class="error-massage" v-show="this.userBlogMessages.descriptionError != ''">@{{userBlogMessages.categoryError}}</small>
            </div>
            <div class="form-group">
              <label for="exampleInputDescription mb-2">Description<span class="error-massage">*</span></label>
              <textarea rows="4" class="form-control" v-model="userNewPost.description" maxlength="1000" aria-describedby="descriptionHelp" placeholder="Please enter description of blog">
              </textarea>
              <small class="error-massage" v-show="this.userBlogMessages.descriptionError != ''">@{{userBlogMessages.descriptionError}}</small>
            </div>
            <p><a href="#" data-toggle="collapse" data-target="#moreDetails" > More Details</a></p>
            <br>
            <div id="moreDetails" class="collapse">
              <div class="form-group">
                <label for="exampleInputStatus mb-2">Status : </label>
                <label class="radio-inline"><input v-model="userNewPost.status" type="radio" value="public"  checked="checked"> Public</label>
                <label class="radio-inline"><input v-model="userNewPost.status" type="radio" value="private"> Private</label>
              </div>
              <div class="form-group">
                <label for="exampleInputCommentable mb-2">Commentable : </label>
                <label class="radio-inline"><input v-model="userNewPost.canComment" type="radio" value="yes" checked="checked"> Yes</label>
                <label class="radio-inline"><input v-model="userNewPost.canComment" type="radio" value="no"> No</label>
              </div>
            </div>
            <a href="#" v-on:click="validateBlogData()" class="btn btn-primary submit mb-4">Post Blog</a>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
  <h3 class="tittle">Blog Posts</h3>
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
          <form action="#" method="post">
            <input type="email" placeholder="Email" required="">
            <input type="submit" value="Subscribe">
          </form>
        </div>
        <div class="tech-btm">
          <h4>Categories</h4>
          <ul class="list-group single">
            <li v-for="(category, index) in userPostCategories" class="list-group-item d-flex justify-content-between align-items-center">
              @{{category.category_name}}
              <span class="badge badge-primary badge-pill">@{{category.count}}</span>
            </li>
          </ul>
        </div>
        <div class="tech-btm">
          <h4>Recent Posts</h4>
          <div v-for="(userPost, index ) in userPosts.slice(0,3)" class="blog-grids row mb-3 text-left">
            <div class="col-md-7 blog-grid-right">
              <h5>
                <a href="single.html">@{{userPost.heading}} </a>
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
@section('script')
@endsection