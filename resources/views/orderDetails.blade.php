@extends('layout.app')

@section('content')
<div class="container mb-4">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped" style="color: #007bff;">
                    <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Addon</th>
                        <th scope="col" class="text-center">Quantity</th>
                        <th scope="col" class="text-right">Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($orderDetails)
                        @foreach($orderDetails->OrderDetail as $detail)
                            <tr>
                                <td>{{ $detail->Product->name }}</td>
                                <td>@if($detail->ProductAddon) {{ $detail->ProductAddon->name }} @else N/A @endif</td>
                                <td><input class="form-control" type="text" readonly value="{{ $detail->quantity }}" /></td>
                                <td class="text-right">{{ $detail->amount }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Sub-Total</td>
                            <td class="text-right">{{ $orderDetails->sub_total }}</td>
                        </tr>
                    @endif

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Tax</td>
                        <td class="text-right">{{ $orderDetails->tax }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong>Total</strong></td>
                        <td class="text-right"><strong>{{ $orderDetails->grand_total }}</strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-right">
                <a class="btn btn-info" href="{{ url('/') }}">Home</a>
                <a class="btn btn-primary" href="{{ url('addProduct') }}">Continue Ordering</a>
            </div>
        </div>
    </div>
</div>
@stop
