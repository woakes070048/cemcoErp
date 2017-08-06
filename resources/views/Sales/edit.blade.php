@extends('baseLayout')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2_metro.css') }}"/>

@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PAGE TITLE & BREADCRUMB-->
            <h3 class="page-title">
               Sales  Section
            </h3>
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="{{URL::to('dashboard')}}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>

                <li>Edit Sale</li>
            </ul>
            <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
    </div>
    <div class="col-md-16">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-reorder"></i>Edit Sales(InvoiceId# {{$sale[0]->invoice_id}})</div>
                <div class="actions">
                    <a class="btn dark" href="{{ URL::to('sales/index') }}">Sales List</a>
                </div>
            </div>
            <div class="portlet-body form">

               {!!Form::model($sale[0],array('action' => array('SaleController@updateSaleData',
           $sale[0]->invoice_id), 'method' => 'POST', 'class'=>'form-horizontal', 'id'=>'sale_form'))!!}
                <div class="form-body">
                    <div style="float: left;width: 80%; margin-left: 20px">
                        @if (Session::has('message'))
                            <div class="alert alert-success">
                                <button data-close="alert" class="close"></button>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                    </div>

                    <div class="alert alert-danger display-hide">
                        <button data-close="alert" class="close"></button>
                        You have some form errors. Please check below.
                    </div>
                    <div class="alert alert-success display-hide">
                        <button data-close="alert" class="close"></button>
                        Your form validation is successful!
                    </div>
                    <div class="portlet-body form" id="testt">
                        <!-- BEGIN FORM-->
                        <div class="form-body">
                            <div class="form-group">
                                <input type="hidden" name="branch_session" id="branch_session" value="{{Session::get('user_branch')}}">
                                <input type="hidden" name="role_session" id="role_session" value="{{Session::get('user_role')}}">
                                @if(Session::get('user_role')=='admin')
                                <div class="col-md-3">
                                    {!!Form::select('branch_id',[null=>'Select branch'] +$branchAll,$saleDetails[0]->branch_id, array('class'=>'form-control branch_id_val','id'=>'edit_branch_id') )!!}
                                </div>
                                @endif
                                <div class="col-md-3">
                                    {!!Form::select('party_id',[null=>'Please Select Party'] + $buyersAll,$sale[0]->party_id, array('class'=>'form-control party_id_val','id'=>'edit_party_id') )!!}
                                </div>
                                <div class="col-md-2">
                                    {!!Form::text('cash_sale',$sale[0]->cash_sale,array('placeholder' => 'Customer Name', 'class' =>
                                    'form-control','id'=>'edit_cash_sale'))!!}
                                </div>
                                <div class="col-md-2">
                                    {!!Form::textArea('address',$sale[0]->address,array('placeholder' => 'Address', 'class' =>
                                    'form-control','id'=>'address', 'rows'=>'3'))!!}
                                </div>
                                <div class="col-md-2">
                                    {!!Form::select('sales_man_id',[null=>'Select Sales Head'] + $salesMan,$sale[0]->sales_man_id, array('class'=>'form-control sales_man_id_val','id'=>'sales_man_id_val_edit') )!!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-5">
                                    {!!Form::hidden('invoice_id',null,array('class' => 'form-control','id'=>'detail_invoice_id'))!!}
                                </div>
                            </div>

                            <div class="row">
                                <table class="table table-striped table-bordered table-primary table-condensed" id="saleTable">
                                    <thead>
                                    <tr>

                                        <th width="">Product Name</th>
                                        <th width="">Stock Name</th>
                                        <th width="">Price</th>
                                        <th width="">Quantity</th>
                                        <th width="">Remarks</th>
                                        <th width="">Action</th>
                                    </tr>

                                    </thead>
                                    @if(COUNT($saleDetails) > 0)

                                    @foreach($saleDetails as $saleDetail)
                                        <?php

                                        $branch = new \App\Branch();
                                        $stocks = new \App\StockInfo();
                                        $stockName = \App\StockInfo::find($saleDetail->stock_info_id);
                                        $branchName = \App\Branch::find($saleDetail->branch_id);
                                                ?>
                                        <tr>

                                            <td> {{ $saleDetail->product->name }}</td>
                                            <td> {{ $stockName->name }}</td>
                                            <td> {{ $saleDetail->price }}</td>
                                            <td> {{ $saleDetail->quantity }}</td>
                                            <td>
                                                @if($saleDetail->remarks)
                                                {{ $saleDetail->remarks }}
                                                @else
                                                    {{"Not Available"}}
                                                @endif
                                            </td>
                                            <td> <input type="button"  style="width:63px;" value="delete" class="btn red deleteSaleDetail" rel={{$saleDetail->id}} /></td>

                                        </tr>

                                    @endforeach
                                    @endif
                                    <tbody>

                                    </tbody>
                                    <tr class="clone_">

                                        <td>
                                            <div class="form-group">
                                                <div class="col-md-11" style="width: 300px;">
                                                    {!!Form::select('product_id',[null=>'Please Select Product'] +$finishGoods,'null', array('class'=>'form-control ','id'=>'edit_product_id') )!!}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-md-11 " style="width: 220px;">
                                                    {!!Form::select('stock_info_id',[null=>'Select Stock'] +$allStockInfos,'null', array('class'=>'form-control ','id'=>'stock_info_id') )!!}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-md-11" style="width: 100px;">
                                                    {!!Form::text('price',null,array('placeholder' => 'Price', 'class' =>
                                                    'form-control','id'=>'price'))!!}
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-md-11" style="width: 100px;">
                                                    {!!Form::text('quantity',null,array('placeholder' => 'Quantity', 'class' =>
                                                    'form-control','id'=>'quantity'))!!}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-md-11" style="width: 130px;">
                                                    {!!Form::text('remarks','',array('placeholder' => 'Remarks', 'class' =>
                                                    'form-control'))!!}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {!!Form::button('Add ',array('type' => 'button','class' => 'btn blue save editSale' ,'rel'=>$sale[0]->invoice_id))!!}
                                        </td>
                                    </tr>
                                </table>
                                <div class="form-group ">
                                    <label class="control-label col-md-8"></label>
                                    <div class="col-md-4 text-right">
                                        <a class="btn btn-success" href="{{ URL::to('sales/index') }}">Save & Continue</a>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <label class="control-label col-md-4"></label>
                                    <div class="col-md-7 balance_show">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- END FORM-->
                    </div>

                    {!!Form::close()!!}
                            <!-- END FORM-->
                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>

@stop
@section('javascript')
    {!! HTML::script('js/sales.js') !!}
    {!! HTML::script('assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') !!}
    {!! HTML::script('assets/plugins/select2/select2.min.js') !!}

@stop


