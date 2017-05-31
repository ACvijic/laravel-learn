@extends('layouts.admin.layout')

@section('seo-title')
<title> All comments {{ config('app.seo-title-separator') }} {{ config('app.name') }}</title>
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
            <h1 class="page-header">All comments</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    
    @include('layouts.admin.partials.message')
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <label><input class="radio-inline status-button" type="radio" name="reported" value="0">Show all reported</label>
                    <br>
                    <label><input checked class="radio-inline status-button" type="radio" name="active" value="1">Only show active</label>
                    <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">For product/comment:</th>
                                <th class="text-center">Name</th>
                                <th>email</th>
                                <th>Title</th>
                                <th>Text</th>
                                <th class="text-center">Number of likes</th>
                                <th>Reported</th>
                                <th class="text-center">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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
    var table = $('#dataTables-example').DataTable({
        order: [ 1, "asc" ],
        responsive: true,
        columnDefs: [
            { 
                orderable: false, targets: [4, 6, 7]
            },
            { 
                searchable: false, targets: [5, 6, 7]
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

$(function () {
  $('.btn-tooltip').tooltip();
})

</script>
@endsection
