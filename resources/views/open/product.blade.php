@extends('layouts.jango.layout')

@section('seo-title')
<title> Product: {{$product->name}} {{ config('app.seo-title-separator') }} {{ config('app.name') }}</title>
@endsection

@section('content')
<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">

@include('layouts.jango.partials.breadcrumbs')

<!-- BEGIN: PAGE CONTENT -->
<!-- BEGIN: BLOG LISTING -->
<div class="c-content-box c-size-md">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="c-content-blog-post-1-view">
                    <div class="c-content-blog-post-1">
                        <div class="c-media c-content-overlay">
                            <img class="c-overlay-object img-responsive" src="{{ ProductHelper::imagePath($product, 'xl') }}" alt="">
                        </div>
                        <div class="c-title c-font-bold c-font-uppercase">
                            {{ $product->name }}
                        </div>
                        <div class="c-panel c-margin-b-30">
                            <div class="c-date">on
                                <span class="c-font-uppercase">{{ $product->created_at }}</span>
                            </div>
                            <ul class="c-tags c-theme-ul-bg">
                                <a id="comment-on-product" href="{{ url()->current() . "#comment" }}" class="btn btn-info btn-xs text-uppercase">leave a comment</a>
                            </ul>
                            <div class="c-comments">
                                    <i class="icon-speech"></i> {{ $product->numberOfComments() }}
                            </div>
                        </div>
                        <div class="c-desc">
                            <p>{!! $product->text !!}</p>
                        </div>
                        <div class="c-comments">
                            <div class="c-content-title-1">
                                <h3 class="c-font-uppercase c-font-bold">Comments({{ $product->numberOfComments() }})</h3>
                                <div class="c-line-left"></div>
                            </div>
                            @if(isset($allComments))
                            <div class="c-comment-list">
                                @foreach($allComments as $comment)
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <img class="media-object" alt="" src="assets/base/img/content/team/team3.jpg"> </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <span class="c-font-bold">{{ $comment->title }}</span>
                                            <br>
                                            <a href="#" class="c-font-10">@if(isset($comment->name)) {{ $comment->name }} @else anonymous @endif</a> on
                                            <span class="c-date">@if(isset($comment->name)) {{ $comment->created_at }} @else NA @endif</span>
                                        </h4> 
                                        {{ $comment->text }}
                                        <a id="comment-on-comment" href="{{ url()->current() . "#comment" }}" class="btn btn-info btn-xs "><span class=" fa fa-paper-plane-o"></span></a>
                                        <?php
                                            $subcomments = $comment->commentedOn;
                                        ?>                                       
                                        @if(isset($subcomments))
                                        @foreach ($subcomments as $comment)
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img class="media-object" alt="" src="assets/base/img/content/team/team4.jpg"> </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    <span class="c-font-bold">{{ $comment->title }}</span>
                                            <br>
                                            <a href="#" class="c-font-10">@if(isset($comment->name)) {{ $comment->name }} @else anonymous @endif</a> on
                                            <span class="c-date">@if(isset($comment->name)) {{ $comment->created_at }} @else NA @endif</span>
                                                </h4> 
                                                {{ $comment->text }}
                                                <button id="comment-on-comment" class="btn btn-info btn-xs"><span class=" fa fa-paper-plane-o"></span></button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>       
                            @endif
                            <div id="comment">
                                <div class="c-content-title-1">
                                    <h3 class="c-font-uppercase c-font-bold">Leave A Comment</h3>
                                    <div class="c-line-left"></div>
                                </div>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <input id="name" type="text" name="name" placeholder="Your Name" class="form-control c-square"> 
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="email" placeholder="Your Email" class="form-control c-square"> 
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="title" placeholder="Title" class="form-control c-square"> 
                                    </div>
                                    <div class="form-group">
                                        <textarea rows="8" name="text" placeholder="Write comment here ..." class="form-control c-square"></textarea>
                                    </div>
                                    <input id="product_id" class="hidden" name="product_id" type="text" value="">
                                    <input id="comment_id" class="hidden" name="comment_id" type="text" value="0">
                                    <div class="form-group">
                                        <button type="submit" class="btn c-theme-btn c-btn-uppercase btn-md c-btn-sbold btn-block c-btn-square">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @include('layouts.jango.partials.sidebar')
        </div>
        <div class="row">
            <hr>
            <div class="text-center">
                <span>
                    
                @if(is_array($recentProductsForBlade))
                    @foreach($recentProductsForBlade as $value)
                    <div class="col-md-3">
                        <h1>{{ $value->name }}</h1>
                    </div>
                    @endforeach
                @else
                There are no other recent products
                @endif
                </span>
            </div>
            <hr>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
$(document).ready(function(){
    
    var productId = "{{ $product->id }}";
    <?php if(isset($comment)){ ?>
    var commentId = "{{ $comment->id }}";
    <?php } ?>
    if(typeof(commentId) !== "undefined" && commentId !== null){
    $("#comment-on-comment").on('click', function () { 
        
       $("#name").focus();
        $("#product_id").val() = productId;
        $("#comment_id").val() = commentId;
    });
    }
    $("#comment-on-product").click(function () {
        $("#name").focus();
        $("#product_id").val() = productId;
        $("#comment_id").val(0);
    });
    
});
</script>
@endsection
