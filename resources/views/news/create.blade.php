@extends('layouts.admin.layout')

@section('seo-title')
<title> Create a news article {{ config('app.seo-title-separator') }} {{ config('app.name') }}</title>
@endsection


@section('plugins-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create a news article</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    
    
    @include('layouts.admin.partials.message')
    
    <div class="row">
        <div class="col-lg-6">
            <div id="languages">                
                <div class="alert alert-info clearfix">
                    
                    <a class="text-capitalize" href="{{ route('news-create', $defaultLanguage->id) }}">{{ $defaultLanguage->name }}</a>
                    
                    @if(!empty($otherLanguages))
                        @foreach($otherLanguages as $language)
                         &rang; <span class="text-capitalize" href="#">{{ $language->name }}</span>
                        @endforeach
                    @endif
                </div>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-body">
                        
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label>* Title: </label>
                            <input class="form-control" type="text" name="title" value="{{ old('title') }}" autofocus>
                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label>Description: </label>
                            <textarea class="form-control" rows="3" name="description">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                            <label>* Text: </label>
                            <textarea class="form-control" rows="3" name="text" id="text">{{ old('text') }}</textarea>
                            @if ($errors->has('text'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('text') }}</strong>
                                </span>
                            @endif
                        </div>
                        <hr>
                        <div class="form-group{{ $errors->has('seo_title') ? ' has-error' : '' }}">
                            <label>* Seo title: </label>
                            <input class="form-control" type="text" name="seo_title" value="{{ old('seo_title') }}">
                            @if ($errors->has('seo_title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('seo_title') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('seo_description') ? ' has-error' : '' }}">
                            <label>Seo description: </label>
                            <textarea class="form-control" rows="3" name="seo_description">{{ old('seo_description') }}</textarea>
                            @if ($errors->has('seo_description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('seo_description') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('seo_keywords') ? ' has-error' : '' }}">
                            <label>Seo keywords: </label>
                            <input class="form-control" type="text" name="seo_keywords" value="{{ old('seo_keywords') }}">
                            @if ($errors->has('seo_keywords'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('seo_keywords') }}</strong>
                                </span>
                            @endif
                        </div>
                        <hr>
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label>Image: </label>
                            <input id="image" type="text" name="image">
                            <button id="image_upload"><span class="fa fa-upload" ></span></button>
                            @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group{{ $errors->has('publish_date') ? ' has-error' : '' }}">
                            <label>Publish date: </label>
                            <div class='input-group date' id='publishDate'>
                                <input type='text' name="publish_date" class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            @if ($errors->has('publish_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('publish_date') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <input class="hidden" id="action" type='text' name="action" value=""/>
                    </div>
                    <div class="panel-footer">
                        <ul class="list-inline">
                            <li>
                                <button type="submit" data-action='edit' id="edit" class="btn btn-primary">Save & edit in another language</button>
                            </li>
                            <li>
                                <button type="submit" data-action='addAnother' id="add_another" class="btn btn-primary">Save & add another article</button>
                            </li>
                            <li>
                                <button type="submit" data-action='goToList' id="go_to_list" class="btn btn-primary">Save & go to list</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->


@endsection

@section('plugin-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/af.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

@endsection

@section('custom-js')
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'text', {
        filebrowserBrowseUrl : "{{ url('/filemanager/popup') }}",
        uiColor : '#d9edf7'
    });
    
</script>
<script>
$(document).ready(function(){
    
    $("#edit").click(function (e) {
        var button = $(this);
        $('#action').val(button.data('action'));
    });
    $("#add_another").click(function (e) {
        var button = $(this);
        $('#action').val(button.data('action'));
    });
    $("#go_to_list").click(function (e) {
        var button = $(this);
        $('#action').val(button.data('action'));
    });
    
    
    $('#image_upload').on('click', function(e){
        e.preventDefault();
        window.open('/filemanager/popup?CKEditorFuncNum=filldata', 'myWindow', "width=2000, height=600");        
    });
    
    function filldata(data) {
        console.log(data);
    }
    
});

$('#publishDate').datepicker({});
</script>
@endsection

