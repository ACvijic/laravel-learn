@extends('layouts.admin.layout')

@section('seo-title')
<title> All posts {{ config('app.seo-title-separator') }} {{ config('app.name') }}</title>
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
            <h1 class="page-header">All posts</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    
    @include('layouts.admin.partials.message')
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <label><input class="radio-inline status-button" type="radio" name="status" value="0">Show all inactive</label>
                    <br>
                    <label><input checked class="radio-inline status-button" type="radio" name="status" value="1">Show all active</label>
                    <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Body</th>
                                <th class="text-center">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right">

                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tfoot>
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
    $('#dataTables-example tfoot th').each( function (i) {
        var title = $(this).text();
        if(i == 2){
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        }
    } );
    
    
    var table = $('#dataTables-example').DataTable({
        order: [ 1, "asc" ],
        responsive: true,
        columnDefs: [
            { 
                orderable: false, targets: [0,4]
            },
            { 
                searchable: false, targets: [0,4]
            }
        ],
        serverSide: true,
        ajax: {
            url: "{{ url('/posts/dataTable') }}",
            type: 'POST',
            data: function(d) {
                    d.show_with_status = $('.status-button:checked').val();
                    d._token = "{{ csrf_token()}}";
                }
            }
    });
    
    // Apply the search
    table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
    $(':radio').on('change', function(){
        table.draw();
    });
    
    
});


$('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var postId = button.data('postid');
    var postHref = button.data('href');
    var postTitle = button.data('posttitle');// Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-title').text(button.data('modaltitle'));
    modal.find('.modal-body').text(button.data('modalbody'));
    modal.find('.modal-button').text(button.data('buttontext'));
    modal.find('.modal-button').on("click", function(e){
        e.preventDefault();
        $.ajax({
            url:"{{ route('posts-change-status') }}",
            method: 'POST',
            data: {
                id: postId,
                _token: '{{ csrf_token() }}',
            }, 
            success: function(){ // What to do if we succeed
                alert('Status changed successfully!'); 
            },
            error: function(){
                alert('Sth went wrong');
            }
        });
    });
});

$('#imagePreviewModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-title').text("Preview image for post: " + button.data('posttitle'));
    modal.find('#image-preview').attr('src', button.data('src'));
})

$(function () {
  $('.btn-tooltip').tooltip();
})

</script>
@endsection
