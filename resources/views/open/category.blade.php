@extends('layouts.jango.layout')

@section('seo-title')
<title> {{ $category->name }} products {{ config('app.seo-title-separator') }} {{ config('app.name') }}</title>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="c-content-blog-post-1-view">
                                <div class="c-content-blog-post-1">
                                    <image src="{{ CategoryHelper::imagePath($category, "xl") }}">
                                    <div class=" text-center c-title c-font-bold c-font-uppercase">
                                        <a href="#">{{ $category->name }}</a>
                                    </div>
                                    <div class="c-desc"> 
                                        {!! substr($category->text,0 ,200) . "..." !!}
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            @if(!empty($requestedProducts))
                                @foreach($requestedProducts as $product)
                                    <div class="col-md-6">
                                        <div class="c-content-blog-post-card-1 c-option-2 c-bordered">
                                            <div class="c-media c-content-overlay">
                                                <div class="c-overlay-wrapper">
                                                    <div class="c-overlay-content">
                                                        <a href="{{ $product->getSlug() }}">
                                                            <i class="icon-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <img class="c-overlay-object img-responsive" src="{{ ProductHelper::imagePath($product, 'l') }}" alt="">
                                            </div>
                                            <div class="c-body">
                                                <div class="c-title c-font-bold c-font-uppercase">
                                                    <a href="{{ $product->getSlug() }}">{{ $product->name }}</a>
                                                </div>
                                                <div class="c-author"> On
                                                    <span class="c-font-uppercase">{{ $product->created_at }}</span>
                                                </div>
                                                <div class="c-panel">
                                                    <ul class="c-tags c-theme-ul-bg">
                                                        <li>Category: </li>
                                                    </ul>
                                                    <div class="c-comments">
                                                        <a href="#">
                                                            <i class="icon-speech"></i> Number of comments</a>
                                                    </div>
                                                </div>
                                                <p> {!! $product->text !!} </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            
                            @endif
                    </div>
                </div>
                @include('layouts.jango.partials.sidebar')
            </div>
        </div>
    </div>
    <!-- END: BLOG LISTING  -->
    <!-- END: PAGE CONTENT -->
</div>
<!-- END: PAGE CONTAINER -->
@endsection

@section('custom-js')

@endsection