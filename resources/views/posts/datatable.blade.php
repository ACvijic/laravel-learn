<?php


$datatableJson = [
    'draw' => $draw,
    'recordsTotal' => $total,
    'recordsFiltered' => $filteredResults,
    'data' => []
];

foreach ($posts as $post){
    $row = [];
    
    foreach ($columns as $column){
        
        switch($column){
            case 'image':
                ob_start();
                ?>
                    <img class="img-responsive center-block" src="{{ $post->image }}" style="max-width: 200px; height: auto;" data-src='{{ $post->image }}' data-toggle="modal" data-target="#imagePreviewModal" data-posttitle="{{ $post->title }}">
                <?php
                $row[] = ob_get_clean();
                break;
            case 'options':
                ob_start();
                ?>
                    <a data-placement="top" data-id="edit" title="Edit post" href="" class="btn btn-success btn-xs btn-tooltip">Edit</a>
                    @if($post->status == 0)
                        <a data-placement="top" data-id="change_status" title="Show post" data-modaltitle="Show post" data-modalbody="Are you sure that you want activate post '{{$post->title}}'?" data-buttontext='Show' data-postid="{{ $post->id }}" data-href="" class="btn btn-warning btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Show</a>
                    @else
                        <a data-placement="top" data-id="change_status" title="Hide post" data-modaltitle="Hide post" data-modalbody="Are you sure that you want hide post '{{$post->title}}'?" data-buttontext='Hide' data-postid="{{ $post->id }}" data-href="F"  data-posttitle="{{ $post->title }}" class="btn btn-success btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Hide</a>
                    @endif
                    <a data-placement="top" data-id="delete_image" title="Delete image" data-modaltitle="Delete image" data-modalbody="Are you sure that you want to delete image for post '{{$post->title}}'?" data-buttontext='Delete image' data-postid="{{ $post->id }}" data-href=""  data-posttitle="{{ $post->title }}" class="btn btn-danger btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Delete image</a>
                    <a data-placement="top" data-id="delete" title="Delete post" data-modaltitle="Delete post" data-modalbody="Are you sure that you want to delete post '{{$post->title}}'?" data-buttontext='Delete post' data-postid="{{ $post->id }}" data-href=""  data-posttitle="{{ $post->title }}" class="btn btn-danger btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Delete</a>
                <?php
                $row[] = ob_get_clean();
                break;
            default: $row[] = $post->$column;
                break;
        }
    }
    
    $datatableJson['data'][] = $row;
}
echo json_encode($datatableJson);
