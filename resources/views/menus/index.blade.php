@extends('layouts.admin.layout')

@section('seo-title')
<title> Menus {{ config('app.seo-title-separator') }} {{ config('app.name') }}</title>
@endsection

@section('plugins-css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Menu</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    @include('layouts.admin.partials.message')

    <div class="alert alert-info clearfix">
        <a href="{{ route('menus-list') }}">Home</a>
        @if($menu->parent_id > 0)
            / <a href="{{ route('menus-list', $menu->topmenu->id) }}">{{ $menu->topmenu->title }}</a>
        @endif
        @if(!empty($menu->id))
        / <a href="{{ route('menus-list', $menu->id) }}">{{ $menu->title }}</a>
        @endif

        <button id="submit-form" type="button" class="btn btn-success btn-circle btn-sm pull-right">
            <i class="fa fa-check"></i>
        </button>
        <button id="launch-sortable" type="button" class="btn btn-warning btn-circle btn-sm pull-right">
            <i class="fa fa-list"></i>
        </button>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if(count($menusFirstLevel) > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center for-sort">#</th>
                                    <th>Title</th>
                                    <th>Url (slug)</th>
                                    <th class="text-center">Options</th>
                                </tr>
                            </thead>
                            <tbody id='sortable'>
                                @foreach($menusFirstLevel as $value)
                                <tr id="{{ $value->id }}" @if($value->visible == 0) class='danger' @endif>
                                    <td class="text-center for-sort">{{ $value->priority }}</td>
                                    <td>
                                        <a @if(count($value->submenus) > 0) href="{{ route('menus-list', $value->id) }}" @endif class="btn btn-default btn-xs"><span class="fa fa-tasks"></span></a>
                                        {{ $value->title }} ({{ count($value->submenus) }})
                                    </td>
                                    <td>{{ $value->getSlugEasier() }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a data-toggle="tooltip" data-placement="left" title="Edit menu" href="{{ route('menus-edit', $value->id) }}" class="btn btn-default btn-sm btn-tooltip"><span class="fa fa-pencil"></span></a>
                                            @if($value->visible == 1)
                                            <a 
                                                data-placement="top" 
                                                title="Hide menu"
                                                data-modaltitle="Hide menu" 
                                                data-modalbody="Are you sure you want hide the menu: '{{$value->title}}'?" 
                                                data-buttontext='Hide' 
                                                data-menuid="{{ $value->id }}" 
                                                data-href="{{ route('menus-change-status', $value->id) }}"  
                                                data-menutitle="{{ $value->title }}" 
                                                class="btn btn-default btn-sm btn-tooltip"
                                                data-toggle="modal" 
                                                data-target="#myModal"
                                                >
                                                <span class="fa fa-times"></span>
                                            </a>
                                            @else
                                            <a 
                                                data-placement="top" 
                                                title="Show menu"
                                                data-modaltitle="Show menu" 
                                                data-modalbody="Are you sure you want the menu: '{{$value->title}}' to be visible?" 
                                                data-buttontext='Show' 
                                                data-menuid="{{ $value->id }}" 
                                                data-href="{{ route('menus-change-status', $value->id) }}"  
                                                data-menutitle="{{ $value->title }}"
                                                class="btn btn-default btn-sm btn-tooltip"
                                                data-toggle="modal" 
                                                data-target="#myModal"
                                                >
                                                <span class="fa fa-check"></span>
                                            </a>
                                            @endif
                                            <a 
                                                data-placement="right" 
                                                title="Delete menu"
                                                data-modaltitle="Delete menu" 
                                                data-modalbody="Are you sure you want to delete the menu: '{{$value->title}}' ?" 
                                                data-buttontext='Delete' 
                                                data-menuid="{{ $value->id }}" 
                                                data-href="{{ route('menus-delete', $value->id) }}"  
                                                data-menutitle="{{ $value->title }}"
                                                class="btn btn-default btn-sm btn-tooltip"
                                                data-toggle="modal" 
                                                data-target="#myModal"
                                                >
                                                <span class="fa fa-trash"></span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
<!-- /.container-fluid -->
<form id="order-state-form" method="post" action="/menus/reorder" class="hide">
    {{ csrf_field() }}
    <input name="menu" value="<?php if (!empty($menu->id)) { echo $menu->id; } else { echo 0; }?>">
    <input id="order-state" type="text" name="new-state" value="">
</form>
<!-- Modal for option buttons-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a href="" type="button" class="btn btn-warning modal-button"></a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

@section('plugins-js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@section('custom-js')
<script>
$(document).ready(function () {
    $("#submit-form").hide();
    $(".for-sort").hide();
    $("#sortable").sortable({
        disabled: true
    });
});

$("#launch-sortable").click(function () {
    $("#sortable").sortable("enable");
    $(".for-sort").show();
    $(this).hide();
});

$(function () {
    $("#sortable").sortable({
        update: function () {
            var state = $(this).sortable('toArray').toString();
            $("#order-state").val(state);
            $(".for-sort").show();
            $("#submit-form").show();
        }
    });
});

$("#submit-form").click(function () {
    $('#order-state-form').submit();
});

$('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var pageId = button.data('menuid');
    var pageHref = button.data('href');
    var pageTitle = button.data('menutitle');// Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-title').text(button.data('modaltitle'));
    modal.find('.modal-body').text(button.data('modalbody'));
    modal.find('.modal-button').text(button.data('buttontext'));
    modal.find('.modal-button').attr('href', button.data('href'));
});

$(function () {
  $('.btn-tooltip').tooltip();
});
</script>
@endsection