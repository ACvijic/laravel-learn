@extends('layouts.admin.layout')

@section('seo-title')
<title> Test form (frontend - validation) {{ config('app.seo-title-separator') }} {{ config('app.name') }}</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"> Test form (frontend - validation) </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <form id="testform" action="" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-body">
                        
                        <div class="form-group">
                            <label>* username: <small class="text-muted">(alphanumeric)</small></label>
                            <input class="form-control" type="text" name="username" value="{{ old('username') }}" autofocus>
                        </div>
                        
                        <div class="form-group">
                            <label>* description: <small class="text-muted">(lettersonly)</small></label>
                            <textarea class="form-control" rows="3" name="description">{{ old('description') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>* name: <small class="text-muted">(nowhitespaces)</small></label>
                            <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                        </div>
                        
                        <div class="form-group">
                            <label>* story: <small class="text-muted">(minlength [100] )</small></label>
                            <textarea class="form-control" rows="3" name="story">{{ old('story') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>* summary: <small class="text-muted">(maxlength [600] )</small></label>
                            <textarea class="form-control" rows="3" name="summary">{{ old('summary') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>* text with length in range: <small class="text-muted">(rangelength [15, 25] )</small></label>
                            <textarea class="form-control" rows="3" name="ranged_text">{{ old('ranged_text') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>* checkbox with a number of fields selected: <small class="text-muted">(rangelength [1, 3] )</small></label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="" name="ranged_checkbox">option 1
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="" name="ranged_checkbox">option 2
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="" name="ranged_checkbox">option 3
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="" name="ranged_checkbox">option 4
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>* text with a minimal amount of words: <small class="text-muted">(minwords [5] )</small></label>
                            <textarea class="form-control" rows="3" name="min_text">{{ old('min_text') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>* text with a maximal amount of words: <small class="text-muted">(maxwords [5] )</small></label>
                            <textarea class="form-control" rows="3" name="max_text">{{ old('max_text') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>* pattern: <small class="text-muted">(pattern [/\/\.\.\w+/] )</small></label>
                            <input class="form-control" type="text" name="pattern" value="{{ old('pattern') }}">
                        </div>
                        
                        <div class="form-group">
                            <label>* email: <small class="text-muted">(email)</small></label>
                            <input class="form-control" type="text" name="email" value="{{ old('email') }}">
                        </div>
                        
                        <div class="form-group">
                            <label>* url: <small class="text-muted">(url)</small></label>
                            <input class="form-control" type="text" name="url" value="{{ old('url') }}">
                        </div>
                        
                        <div class="form-group">
                            <label>* equal to: <small class="text-muted">(equalTo [previous url] )</small></label>
                            <input class="form-control" type="text" name="equal" value="{{ old('equal') }}">
                        </div>
                        
                        <hr>
                        
                        <div class="form-group">
                            <label>* normalizer: <small class="text-muted">(normalizer [canonical url] )</small></label>
                            <input class="form-control" type="text" name="cannonic_url" value="{{ old('cannonic_url') }}">
                        </div>
                        
                        <div class="form-group">
                            <label>* normalizer: <small class="text-muted">(normalizer [stripped text] )</small></label>
                            <input class="form-control" type="text" name="stripped_text" value="{{ old('stripped_text') }}">
                        </div>
                        
                        <hr>
                        
                        <div class="form-group">
                            <label>* phone: <small class="text-muted">(diigits)</small></label>
                            <input class="form-control" type="text" name="phone" value="{{ old('phone') }}">
                        </div>
                        
                        <div class="form-group">
                            <label>* price: <small class="text-muted">(integer)</small></label>
                            <input class="form-control" type="text" name="price" value="{{ old('price') }}">
                        </div>
                        
                        <div class="form-group">
                            <label>* decimal: <small class="text-muted">(number)</small></label>
                            <input class="form-control" type="text" name="decimal" value="{{ old('decimal') }}">
                        </div>
                        
                        
                        <div class="form-group">
                            <label>* percent: <small class="text-muted">(5-80)</small></label>
                            <input class="form-control" type="text" name="percent" value="{{ old('percent') }}">
                        </div>
                        
                    </div>
                    <div class="panel-footer">
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- /.container-fluid -->
@endsection

@section('plugin-js')
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.js"></script>
@endsection

@section('custom-js')
<script>
$(document).ready(function () {

    $('#testform').validate({ // initialize the plugin
        errorElement: "div",
        errorClass: "alert alert-danger",
        highlight: function(element, errorClass) {
            $(element).parent().addClass("has-error");
        },
        unhighlight: function(element) {
            $(element).parent().removeClass('has-error').addClass('has-success');
        },
//        errorPlacement: function(error, element) {
//            error.insertAfter($(element);
//        },
        rules: {
            username: {
                required: true,
                alphanumeric: true
            },
            description: {
                required: true,
                lettersonly: true
            },
            name: {
                required: true,
                nowhitespace: true
            },
            story: {
                required: true,
                minlength: 100
            },
            summary: {
                required: true,
                maxlength: 600
            },
            ranged_text: {
                required: true,
                rangelength: [15,25]
            },
            ranged_checkbox: {
                required: true,
                rangelength: [1,3]
            },
            min_text: {
                required: true,
                minwords: 5
            },
            max_text: {
                required: true,
                maxwords: 5
            },
            pattern: {
                required: true,
                pattern: '/\/\.\.\w+/'
            },
            email: {
                required: true,
                email: true
            },
            url: {
                required: true,
                url: true
            },
            equal: {
                required: true,
                equalTo: 5
            },
            cannonic_url: {
                required: true,
//                normalizer: function( value ) {
//                    var url = value;
//
//                    // Check if it doesn't start with http:// or https:// or ftp://
//                    if ( url && url.substr( 0, 7 ) !== "http://"
//                            && url.substr( 0, 8 ) !== "https://"
//                            && url.substr( 0, 6 ) !== "ftp://" ) {
//                      // then prefix with http://
//                      url = "http://" + url;
//                    }
//
//                    // Return the new url
//                    return url;
//                }


            },
            stripped_text: {
                required: true,
                normalizer: function( value ) {
                    // Trim the value of the `field` element before
                    // validating. this trims only the value passed
                    // to the attached validators, not the value of
                    // the element itself.
                    return $.trim( value );
                }
            },
            phone: {
                required: true,
                digits: true
            },
            price: {
                required: true,
                integer: true
            },
            decimal: {
                required: true,
                number: true
            },
            percent: {
                required: true,
                min: 5,
                max: 80,
            },
        },
        
    });
    
    
    
});
</script>
@endsection

