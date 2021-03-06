@extends('layouts.admin')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script type="text/javascript">
    function totalAmount(){
        var t = 0;
        $('.amount').each(function(i,e){
            var amt = $(this).val()-0;
            t += amt;
        });
        $('.total').html(t);
    }
    </script>

<style>
    .hidden{
        display : none;
    }
    .show{
        display : block !important;
    }
    select.form-control.product_id {
        width: 150px;
    }
</style>
@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Point of Sale</li>
        </ol>
        @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade show rounded" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span></button> <i class="fa fa-info mx-2"></i>
                <strong>{!! session('message') !!}</strong>
            </div>
        @endif
        <div id="poss"></div><h2>POS</h2>

        <div class="container">

            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">New Sale</div>

                        <div class="panel-body">
                            <form class="form-horizontal" id="yoyo" role="form" method="POST" action="{{ url('/admin/invoices') }}">
                                {!! csrf_field() !!}
                                <table class="table table-striped">
                                    <tr>
                                        <td>
                                            Client Name:

                                            @if(empty($clients))
                                                <input type="text" class="form-control" name="clients" value="{{ old('clients') }}">
                                            @else
                                                <select class="form-control client_id" name="client_id[]">
                                                @foreach($clients as $client)
                                                    <option data-name="{!! $client ->address_city !!}" value="{!! $client->id !!}">{!! $client->first_name!!}</option>
                                                @endforeach
                                                </select>
                                             @endif
                                        </td>
                                        <td>
{{--                                            Location: <input type="text" class="form-control" name="location" value="{!! $client ->address_city !!}">--}}
                                            Location: <input type="text" class="form-control" name="location" value="">
                                        </td>
                                    </tr>
                                </table>

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Amount</th>
                                        <th>Delete</th>

                                    </tr>
                                    </thead>
                                    <tbody class="neworderbody">
                                    <tr>
                                        <td class="no">1</td>
                                        <td>
                                            <select class="form-control product_id" name="product_id[]">
                                                @foreach($products as $product)
                                                    <option data-price="{!! $product ->unit_cost !!}" value="{!! $product->id !!}">{!! $product->item_name!!}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="qty form-control" name="qty[]" value="{{ old('email') }}">
                                        </td>
                                        <td>
                                            <input type="text" class="price form-control" name="price[]" value="{{ old('email') }}">
                                        </td>
                                        <td>
                                            <input type="text" class="dis form-control" name="dis[]">
                                        </td>
                                        <td>
                                            <input type="text" class="amount form-control" name="amount[]">
                                        </td>
                                        <td>
                                            <input type="button" class="btn btn-danger delete" value="x">
                                        </td>
                                    </tr>

                                    </tbody>

                                    <tfoot>
                                    <th colspan="6">Total:<b class="total">0</b></th>
                                    </tfoot>


                                </table>
                                <input type="button" class="btn btn-lg btn-primary add" value="Add New Item">
                                <hr>
                            </form>
                        </div>

                    </div>
                </div>
                <!--  Right -->

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Actions</div>

                        <div class="panel-body">
                            <center><input type="submit" class="btn btn-default btn-lg" name="save" value="Place Order">
                                <button type="button" id='hideshow' class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                                    Generate Reciept
                                </button>
                            </center>
                        </div>
                    </div>
                </div>
                </form>
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Reciept</h4>
                            </div>
                            <div class="modal-body">
                                <div class="panel-body " id="toPrint">

                                    <table class="table table-striped" >
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Order Amount </th>
                                            <th>Order Qty</th>
                                            <th>Unit Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                       {{-- @foreach($orders as $order)
                                            <tr>
                                                <td>{!! $order->order_id !!}</td>
                                                <td>{!! $order->amount !!}</td>
                                                <td>{!! $order->quantity !!}</td>
                                                <td>{!! $order->unitprice !!}</td>

                                            </tr>
                                        @endforeach--}}
                                        </tbody>
{{--                                        @foreach($orderby as $cust)--}}
                                            <li><b>Ordered by :{{--</b> {!! $cust->name !!}--}}</li><br>
{{--                                        @endforeach--}}
                                    </table>
                                    <a href="javascript:void(0);" class="btn btn-primary" id="printPage">Print</a>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row End -->

            <script lang='javascript'>
                $(document).ready(function(){
                    $('#printPage').click(function(){
                        var data = '<input type="button" value="Print this page" onClick="window.print()">';
                        data += '<div id="toPrint">';
                        data += $('#toPrint').html();
                        data += '</div>';
                        myWindow=window.open('','','width=1200,height=1000');
                        myWindow.innerWidth = screen.width;
                        myWindow.innerHeight = screen.height;
                        myWindow.screenX = 0;
                        myWindow.screenY = 0;
                        myWindow.document.write(data);
                        myWindow.focus();
                    });
                });
            </script>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
@endsection
