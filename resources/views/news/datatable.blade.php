<?php


$datatableJson = [
    'draw' => $draw,
    'recordsTotal' => $total,
    'recordsFiltered' => $filteredResults,
    'data' => []
];
if(!empty($news)){
    foreach ($news as $article){
        $row = [];

        foreach ($columns as $column){

            switch($column){
                case 'image':
                    ob_start();
                    ?>
                        <img class="img-responsive center-block" src="{{ $article->image }}" style="max-width: 200px; height: auto;" data-src='{{ $article->image }}' data-toggle="modal" data-target="#imagePreviewModal" data-posttitle="{{ $article->title }}">
                    <?php
                    $row[] = ob_get_clean();
                    break;
                case 'options':
                    ob_start();
                    ?>
                        <a data-placement="left" title="Edit article" href="{{ route('news-edit', [$article->news_id, $article->language_id]) }}" class="btn btn-success btn-xs btn-tooltip">Edit</a>
                        @if($article->visible == 0)
                            <a data-placement="top" title="Show article" data-modaltitle="Show article" data-modalbody="Are you sure that you want activate article '{{$article->title}}'?" data-buttontext='Show' data-articleid="{{ $article->id }}" data-href="{{ route('news-change-status', [$article->news_id, $article->language_id]) }}"  data-articletitle="{{ $article->title }}" class="btn btn-warning btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Show</a>
                        @else
                            <a data-placement="top" title="Hide article" data-modaltitle="Hide article" data-modalbody="Are you sure that you want hide article '{{$article->title}}'?" data-buttontext='Hide' data-articleid="{{ $article->id }}" data-href="{{ route('news-change-status', [$article->news_id, $article->language_id]) }}"  data-articletitle="{{ $article->title }}" class="btn btn-success btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Hide</a>
                        @endif
                        <a data-placement="top" title="Delete image" data-modaltitle="Delete image" data-modalbody="Are you sure that you want to delete image for article '{{$article->title}}'?" data-buttontext='Delete image' data-articleid="{{ $article->id }}" data-href="{{ route('news-delete-image', [$article->news_id, $article->language_id]) }}"  data-articletitle="{{ $article->title }}" class="btn btn-danger btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Delete image</a>
                        <a data-placement="right" title="Delete article" data-modaltitle="Delete article" data-modalbody="Are you sure that you want to delete article '{{$article->title}}'?" data-buttontext='Delete article' data-articleid="{{ $article->id }}" data-href="{{ route('news-delete', [$article->news_id, $article->language_id]) }}"  data-articletitle="{{ $article->title }}" class="btn btn-danger btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Delete</a>

                    <?php
                    $row[] = ob_get_clean();
                    break;
                default: $row[] = $article->$column;
                    break;
            }
        }

        $datatableJson['data'][] = $row;
    }
}
echo json_encode($datatableJson);

