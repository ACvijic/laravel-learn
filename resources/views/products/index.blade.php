@extends('layouts.admin.layout')

@section('seo-title')
<title> All products {{ config('app.seo-title-separator') }} {{ config('app.name') }}</title>
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
            <h1 class="page-header">All products</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    
    @include('layouts.admin.partials.message')
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="dataTables-forProducts">
                        <thead>
                            <tr>
                                <th class="text-center">Image</th>
                                <th>Name</th>
                                <th>Text</th>
                                <th>Price (<span class="fa fa-euro"></span>)</th>
                                <th>Discount (<span class="fa fa-percent"></span>)</th>
                                <th class="text-center">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($products) > 0)
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        <?php 
                                        if(isset($product->image)){
                                            $extension = pathinfo($product->image, PATHINFO_EXTENSION); 
                                            $extension = substr($product->image, -(strlen($extension) + 1));
                                            $image = str_replace($extension, "-s" . $extension, $product->image);
                                            $imageXL = str_replace($extension, "-xl" . $extension, $product->image);
                                            ?>
                                            <img class="img-responsive center-block" src="{{ $image }}" data-src='{{ $imageXL }}' data-toggle="modal" data-target="#imagePreviewModal" data-productName="{{ $product->name }}">
                                            <?php
                                        }
                                            
                                        ?>  
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{!! $product->text !!}</td>
                                    <td class="text-center">{{ $product->price }}</td>
                                    <td class="text-center">{{ $product->discount }}</td>
                                    <td class="text-center">
                                        <a data-placement="left" title="Edit product" href="{{ route('products-edit', $product->id) }}"  class="btn btn-success btn-xs btn-tooltip">Edit</a>
                                        @if($product->visible == 0)
                                        <a data-placement="top" title="Show product" data-modaltitle="Show product" data-modalbody="Are you sure that you want to activate the product '{{$product->name}}'?" data-buttontext='Show' data-productid="{{ $product->id }}" data-href="{{ route('products-change-status', $product->id) }}"  data-productname="{{ $product->name }}" class="btn btn-warning btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Show</a>
                                        @else
                                        <a data-placement="top" title="Hide product" data-modaltitle="Hide product" data-modalbody="Are you sure that you want to hide the product '{{$product->name}}'?" data-buttontext='Hide' data-productid="{{ $product->id }}" data-href="{{ route('products-change-status', $product->id) }}"  data-productname="{{ $product->name }}" class="btn btn-success btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Hide</a>
                                        @endif
                                        <a data-placement="top" title="Delete image" data-modaltitle="Delete image" data-modalbody="Are you sure that you want to delete the image for product '{{$product->name}}'?" data-buttontext='Delete image' data-productid="{{ $product->id }}" data-href="{{ route('products-delete-image', $product->id) }}"  data-productname="{{ $product->name }}" class="btn btn-danger btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Delete image</a>
                                        <a data-placement="right" title="Delete product" data-modaltitle="Delete page" data-modalbody="Are you sure that you want to delete the product '{{$product->name}}'?" data-buttontext='Delete product' data-productid="{{ $product->id }}" data-href="{{ route('products-delete', $product->id) }}"  data-productname="{{ $product->name }}" class="btn btn-danger btn-xs btn-tooltip" data-toggle="modal" data-target="#myModal">Delete</a>

                                    </td>
                                </tr>
                                @endforeach
                            @endif
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


@section('plugins-js')
<!-- DataTables JavaScript -->
<script src="/admin/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/admin/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="/admin/vendor/datatables-responsive/dataTables.responsive.js"></script>
@endsection

@section('custom-js')
<script>
$(document).ready(function() {
    $('#dataTables-forProducts').DataTable({
        order: [ 1, "asc" ],
        responsive: true,
        columnDefs: [
            { 
                orderable: false, targets: [0,2,5]
            },
            { 
                searchable: false, targets: [0,2,5]
            }
        ]
    });
});

$('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var productid = button.data('productid');
    var productHref = button.data('href');
    var productname = button.data('productname');// Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-title').text(button.data('modaltitle'));
    modal.find('.modal-body').text(button.data('modalbody'));
    modal.find('.modal-button').text(button.data('buttontext'));
    modal.find('.modal-button').attr('href', button.data('href'));
});

$('#imagePreviewModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('.modal-title').text("Preview image for product: " + button.data('productName'));
    modal.find('#image-preview').attr('src', button.data('src'));
});

$(function () {
  $('.btn-tooltip').tooltip();
})
</script>
@endsection
