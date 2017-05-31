@extends('layouts.admin.layout')

@section('seo-title')
<title> Edit product: {{ $product->name }} {{ config('app.seo-title-separator') }} {{ config('app.name') }}</title>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit product: {{ $product->name }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <form action="" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-body">
                        
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label>* Name: </label>
                            <input class="form-control" type="text" name="name" value="{{ old('name', $product->name) }}" autofocus>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label>* Category: </label>
                            <select class="form-control" name="category_id">
                                @if(!empty($categoriesActive))
                                <option value=''>-- Choose --</option>
                                    @foreach($categoriesActive as $category)
                                        <option value="{{ $category->id }}" @if(old('category_id', $product->category_id) == $category->id) selected  @endif>{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            
                            @if ($errors->has('category_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('category_id') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label>Description: </label>
                            <textarea class="form-control" rows="3" name="description">{{ old('description', $product->description) }}</textarea>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                            <label>* Text: </label>
                            <textarea class="form-control" rows="3" name="text" id="text">{{ old('text', $product->text) }}</textarea>
                            @if ($errors->has('text'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('text') }}</strong>
                                </span>
                            @endif
                        </div>
                        <hr>
                        
                        <?php 
                        if(isset($product->image)){
                            $extension = pathinfo($product->image, PATHINFO_EXTENSION); 
                            $extension = substr($product->image, -(strlen($extension) + 1));
                            $image = str_replace($extension, "-m" . $extension, $product->image);
                            ?>
                            <div class="form-group">
                                <label>Current image:</label>
                                <br>
                                <img src="{{ $image }}">
                            </div>
                            <?php
                        }
                        ?>
                        
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label>New image: </label>
                            <input type="file" name="image">
                            @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>
                        <hr>
                        <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                            <label>* Price: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-eur"></i></span>
                                <input class="form-control" type="text" name="price" value="{{ old('price', $product->price) }}">
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('discount') ? ' has-error' : '' }}">
                            <label>* Discount: </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                <input class="form-control" type="text" name="discount" value="{{ old('discount', $product->discount) }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('discount') }}</strong>
                                    </span>
                                @endif
                            </div>
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

@section('custom-js')
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'text' );
</script>
@endsection

