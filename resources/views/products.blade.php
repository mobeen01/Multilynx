@extends('layout.app')

@section('content')
    <section id="product" class="d-flex align-items-center">
        <div class="container position-relative text-center text-lg-left" data-aos="zoom-in" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-8">
                    @if($errors->any())
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                    @endif
                    @if(count($products) > 0)
                        <div id="accordion">
                            @foreach($products as $product)
                                <div class="card">
                                    <div class="card-header" id="heading{{ $product->id }}">
                                        <div class="form-group row">
                                            <span class="col-md-1"><input class="form-control" type="checkbox" id="product_{{ $product->id }}" value="{{ $product->id }}" onchange="addProducts({{ $product->id }})"></span>
                                            <span class="col-md-9">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#target{{ $product->id }}" aria-expanded="true" aria-controls="target{{ $product->id }}">
                                                    {{ $product->name }}
                                                </button>
                                            </span>
                                            <span class="col-md-2"><input class="form-control" type="number" min="1" id="quantity_{{ $product->id }}" onchange="productQuantity({{ $product->id }})" placeholder="Quantity"></span>
                                        </div>
                                    </div>

                                    @if(count($product->ProductAddon) > 0)
                                        <div id="target{{ $product->id }}" class="collapse" aria-labelledby="heading{{ $product->id }}" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="form-group row">
{{--                                                    <ul>--}}
                                                    @foreach($product->ProductAddon as $addon)
{{--                                                        <li>--}}
                                                            <span class="col-md-1"><input class="form-control" type="checkbox" id="addon_{{ $addon->id }}" value="{{ $addon->id }}" onchange="addAddon({{ $addon->id }}, {{ $product->id }})"></span>
                                                            <span class="col-md-9">{{ $addon->name }}</span>
                                                            <span class="col-md-2"><input class="form-control" type="number" min="1" id="addon_quantity_{{ $addon->id }}" onchange="addonQuantity({{ $addon->id }}, {{ $product->id }})" placeholder="Quantity"></span>
{{--                                                        </li>--}}
                                                    @endforeach
{{--                                                    </ul>--}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="col text-center" style="padding-top: 20px;">
                            <button type="button" class="btn btn-primary col-lg-5" onclick="addToCart()">Place Order</button>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-lg-8" style="color: #007bff;">
                                <h5>Sorry, No product available <span><a href="{{ url('/') }}">Go Home</a></span>.</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div style="display: none;">
            <form method="post" action="{{ url('addToCart') }}" id="addToCartForm">
                @csrf
                <input type="text" id="form_product" name="products" value="">
                <input type="text" id="form_addon" name="addons" value="">
            </form>
        </div>
    </section>
    <script>
        var product = [];
        var addon = [];
        function addProducts(id) {
            if ($("#quantity_" + id).val() == '') {
                alert('Please add quantity');
                $("#product_" + id).prop("checked", false)
                return false;
            }

            var hasMatch = false;
            var ind = 0;

            for (var index = 0; index < product.length; ++index) {

                var checkId = product[index];

                if (checkId.id == id) {
                    hasMatch = true;
                    ind = index;
                    break;
                }
            }
            if ($("#product_" + id).is(':checked')) {
                if (hasMatch == true) {
                    product[ind].quantity = $("#quantity_" + id).val();
                } else {
                    var prod = {};

                    prod = {id: id, quantity: $("#quantity_" + id).val()};

                    product.push(prod);
                }
            } else {
                if (hasMatch == true) {
                    product.splice(ind, 1);
                }
            }

        }

        function productQuantity(id) {
            if ($("#quantity_" + id).val() == '') {
                alert('Please add quantity');
                $("#product_" + id).prop("checked", false)
                return false;
            }

            var hasMatch = false;
            var ind = 0;

            for (var index = 0; index < product.length; ++index) {

                var checkId = product[index];

                if (checkId.id == id) {
                    hasMatch = true;
                    ind = index;
                    break;
                }
            }
            if (hasMatch == true) {
                product[ind].quantity = $("#quantity_" + id).val();
            }
        }

        function addAddon(id, prod_id) {
            if ($("#addon_quantity_" + id).val() == '') {
                alert('Please add quantity');
                $("#addon_" + id).prop("checked", false);
                return false;
            }

            var prodMatch = false;
            for (var index = 0; index < product.length; ++index) {

                var checkId = product[index];

                if (checkId.id == prod_id) {
                    prodMatch = true;
                    ind = index;
                    break;
                }
            }
            if(prodMatch == false) {
                alert("Please select product first.");
                $("#addon_" + id).prop("checked", false);
                return false;
            } else {
                var hasMatch = false;
                var ind = 0;

                for (var index = 0; index < addon.length; ++index) {

                    var checkId = addon[index];

                    if (checkId.id == id) {
                        hasMatch = true;
                        ind = index;
                        break;
                    }
                }
                if ($("#addon_" + id).is(':checked')) {
                    if (hasMatch == true) {
                        addon[ind].quantity = $("#addon_quantity_" + id).val();
                    } else {
                        var prod = {};

                        prod = {id: id, quantity: $("#addon_quantity_" + id).val()};

                        addon.push(prod);
                    }
                } else {
                    if (hasMatch == true) {
                        addon.splice(ind, 1);
                    }
                }
            }
        }

        function addonQuantity(id, prod_id) {
            if ($("#addon_quantity_" + id).val() == '') {
                alert('Please add quantity');
                $("#addon_" + id).prop("checked", false);
                return false;
            }

            var prodMatch = false;
            for (var index = 0; index < product.length; ++index) {

                var checkId = product[index];

                if (checkId.id == prod_id) {
                    prodMatch = true;
                    ind = index;
                    break;
                }
            }
            if(prodMatch == false) {
                alert("Please select product first.");
                $("#addon_" + id).prop("checked", false);
                return false;
            } else {
                var hasMatch = false;
                var ind = 0;

                for (var index = 0; index < addon.length; ++index) {

                    var checkId = addon[index];

                    if (checkId.id == id) {
                        hasMatch = true;
                        ind = index;
                        break;
                    }
                }

                if (hasMatch == true) {
                    addon[ind].quantity = $("#addon_quantity_" + id).val();
                }
            }
        }

        function addToCart() {
            if(product == '') {
                alert('Please select atleast 1 item.');
                return false;
            }
            if(confirm('Are you sure! you want to place order?')) {
                $('#form_product').val(JSON.stringify(product));
                $('#form_addon').val(JSON.stringify(addon));

                $('#addToCartForm').submit();
            }
        }
    </script>
@stop

@section('javascript')

@stop
