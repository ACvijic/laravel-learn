<?php


$datatableJson = [
    'draw' => $draw,
    'recordsTotal' => $total,
    'recordsFiltered' => $filteredResults,
    'data' => []
];

foreach ($comments as $comment){
    $row = [];
    
    foreach ($columns as $column){
        
        switch($column){
            case 'product_or_comment':
                ob_start();
                ?>
                    @if($comment->product_id != 0)
                        <b>For product: </b>
                    @endif
                    @if($comment->comment_id != 0)
                        <b>, For comment: </b>
                    @endif
                <?php
                $row[] = ob_get_clean();
                break;
            case 'options':
                ob_start();
                ?>
                    @if($comment->status == 0)
                        <a data-placement="top" title="Show comment" data-modaltitle="Show comment" data-modalbody="Are you sure that you want activate this comment?" data-buttontext='Show' data-postid="{{ $comment->id }}" data-href="" class="btn btn-warning btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Show</a>
                    @else
                        <a data-placement="top" title="Hide comment" data-modaltitle="Hide comment" data-modalbody="Are you sure that you want hide this comment?" data-buttontext='Hide' data-postid="{{ $comment->id }}" data-href=""  data-posttitle="{{ $comment->title }}" class="btn btn-success btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Hide</a>
                    @endif
                <?php
                $row[] = ob_get_clean();
                break;
            case 'reported':
                ob_start();
                ?>
                    @if($comment->reported == 0)
                        
                    @else
                    <span class="fa fa-flag" style="color:red;" ></span>
                    @endif
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

