@extends('layouts.admin.layout')

@section('seo-title')
<title> All news articles {{ config('app.seo-title-separator') }} {{ config('app.name') }}</title>
@endsection

@section('plugins-css')
<!-- DataTables CSS -->
<link href="/admin/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="/admin/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">All news articles </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    
    @include('layouts.admin.partials.message')
    
    <div class="row">
        <div class="col-lg-12">
            <div id="languages">                
                <div class="alert alert-info clearfix">
                    
                    <a class="text-capitalize @if($langId == $defaultLanguage->id) text-warning disabled @endif" href="@if($langId != $defaultLanguage->id){{ route('news-list', $defaultLanguage->id) }}@else # @endif">{{ $defaultLanguage->name }}</a>
                    
                    @if(!empty($otherLanguages))
                        @foreach($otherLanguages as $language)
                         &rang; <a href="@if($langId != $language->id){{ route('news-list', $language->id) }}@else # @endif" class="text-capitalize @if($langId == $language->id) text-warning disabled @endif">{{ $language->name }}</a>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                            </tr>
                            <tr>
                                <th class="text-center">Image</th>
                                <th>Title</th>
                                <th>Text</th>
                                <th class="text-center">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>

                                </td>
                                <td></td>
                                <td></td>
                                <td class="text-center">

                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
<!-- /.container-fluid -->

<!-- Modal for image preview-->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="imageModalLabel"></h4>
            </div>
            <div class="modal-body text-center">
                <img src="" class="img-responsive center-block" id='image-preview'>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


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
                <a href="" type="button" class="btn btn-danger modal-button"></a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection


@section('plugin-js')
<!-- DataTables JavaScript -->
<script src="/admin/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/admin/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="/admin/vendor/datatables-responsive/dataTables.responsive.js"></script>
@endsection

@section('custom-js')
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
$(document).ready(function() {
    
    // Setup - add a text input to each footer cell
    $('#dataTables-example thead th').each( function (i) {
        var title = $(this).text();
        if( i == 1 || i == 2){
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        }
    } );
    
    $(location).attr('href');

    //pure javascript
    var pathname = window.location.pathname;
    
    var lang = pathname.substring(pathname.lastIndexOf('/') + 1);
    
    var table = $('#dataTables-example').DataTable({
        order: [ 1, "asc" ],
        responsive: true,
        columnDefs: [
            { 
                orderable: false, targets: [0,2,3]
            },
            { 
                searchable: false, targets: [0,2,3]
            }
        ],
        serverSide: true,
        ajax: {
            url: "{{ url('/news/dataTable') }}",
            type: 'POST',
            // set multiple params in data [d argument in closure]
            data: function(d) {
                    d._token = "{{ csrf_token()}}";
                    d.langId = "{{ $langId }}";
            }
        }
    });
    
    // Apply the search
    table.columns().every( function () {
        var that = this;
        // always footer
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
    
});


$('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var articleId = button.data('articleid');
    var articleHref = button.data('href');
    var articleTitle = button.data('articletitle');// Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-title').text(button.data('modaltitle'));
    modal.find('.modal-body').text(button.data('modalbody'));
    modal.find('.modal-button').text(button.data('buttontext'));
    modal.find('.modal-button').attr('href', button.data('href'));
})

$('#imagePreviewModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-title').text("Preview image for article: " + button.data('articletitle'));
    modal.find('#image-preview').attr('src', button.data('src'));
})

$(function () {
  $('.btn-tooltip').tooltip();
})

</script>
@endsection