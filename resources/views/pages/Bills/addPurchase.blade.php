@extends('layouts.app')
@section('body')
    <form action="{{route('createPurchase')}}" method="post" id="formStart">
        @csrf
        <div class="m-2">
            <div class="row">
                <div class="col-2 fw-bold fs-5">
                    Vendor name:
                </div>
                <div class="col-4 fw-bold fs-5">
                    <div class="vendor">
                        <select name="vendor[]" class="w-100 text-center" required>
                            <option value="{{null}}">Select</option>
                            @foreach($vendors as $vendor)
                                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row m-2 d-flex bg-heading">
                <div class="col-3 text-center">Product Name</div>
                <div class="col-3 text-center">Rate</div>
                <div class="col-2 text-center">Quantity</div>
                <div class="col-2 text-center">Price</div>
                <div class="col-2 text-center">Actions</div>
            </div>
            <div class="m-2" id="copyFrom">
                <div class="item-form">
                    <div class="row">
                        <div class="col-3">
                            <select name="product[]" class="w-100 text-center" required>
                                <option value="{{null}}">Select</option>
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3 text-center">
                            <div class="price">
                                <input type="number" name="rate[]" class="w-100 text-center" id="pricePP" required>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="stock">
                                <input type="number" name="stock[]" class="w-100 text-center" id="stockPP" required>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="total">
                                <input type="number" name="total[]" class="w-100 text-center" id="totalPP" required>
                            </div>
                        </div>
                        <div class="col-2 text-center d-none" id="deleteBtn">
                            <label class="delete" onclick="removeProduct(this)">
                                <i class="fas fa-trash-alt"></i>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="m-2" id="copyTo">

        </div>

        <div class="row">
            <div class="col-2">
                <label class="btn item addProduct" onclick="addProduct()">
                    Add Product
                </label>
            </div>
        </div>

        <div class="row m-3">
            <label for="exampleInputPhone" class="form-label">Bill Number</label>
            <input type="text" name="billNum" class="form-control w-100" id="exampleInputPhone">
        </div>
        <div class="m-3">
            <label id="purchase" onclick="purchase()" class="bg-primary rounded-2 p-1 m-1 bHover">Credit
                Amount</label>
            <div class="mb-3 d-none" id="creditPurchaseContent">
                <div class="row">
                    <div class="col-5">
                        <label for="exampleInputAddress" class="">Credit Price</label>
                        <input type="number" name="payable" class="form-control" id="exampleInputAddress">
                    </div>
                    <div class="col-7">
                        <label for="exampleInputPhone" class="form-label">Payment Date</label>
                        <input type="date" name="date" class="form-control" id="exampleInputPhone">
                    </div>
                </div>
            </div>
        </div>
        @if($errors->has('vendor'))
            <div class="error">{{$errors->first('vendor')}}</div>
        @endif
        @if($errors->has('product'))
            <div class="error">{{$errors->first('product')}}</div>
        @endif
        @if($errors->has('stock'))
            <div class="error">{{$errors->first('stock')}}</div>
        @endif
        @if($errors->has('total'))
            <div class="error"> {{$errors->first('total')}}</div>
        @endif
        @if($errors->has('payable'))
            <div class="error"> {{$errors->first('payable')}}</div>
        @endif
        @if($errors->has('date'))
            <div class="error">{{$errors->first('date')}} </div>
        @endif
        @if($errors->has('billNum'))
            <div class="error">{{$errors->first('billNum')}} </div>
        @endif

        <div class="row m-3">
            <div class="text-center col-6 bg-red fs-5 rounded rounded-pill">
                @foreach($errors->all() as $error)
                    {{$error}}
                @endforeach
            </div>
        </div>

        <input class="text-center p-1 m-1 d-none" type="number" id="savedTotal"
        >
        <input class="text-center p-1 m-1 d-none" type="number" disabled name="discountPP" id="discountPP"
        >
        <input class="text-center p-1 m-1 d-none" type="number" disabled name="discountAA" id="discountAA"
        >
        <input class="text-center p-1 m-1 d-none" type="number" disabled name="total" id="total">
        <input class="text-center p-1 m-1 d-none" type="number" disabled name="vat"
               value=0
               id="vat">
        <div class="row">
            <div class="col-7"></div>
            <div class="col-4 billStructure">
                <div class="m-3">
                    <div class="row">
                        <div class="d-flex">
                            <input type="checkbox" id="dButton"> <label class="m-1">Discount</label>
                        </div>
                    </div>

                    <div class="d-none" id="discountClicked">

                        <div class="row">
                            <div class="col-3 text-center">
                                <input type="radio" class="m-2" name="discountRadio"
                                       id="discountRadioPercent" checked><label>%</label>
                            </div>
                            <div class="col-3">
                                <input type="radio" class="m-2" name="discountRadio"
                                       id="discountRadioRS"><label>RS</label>
                            </div>
                        </div>


                        <div class="row">
                            <div class="" id="discountForPercent">
                                <input class="text-center p-1 m-1"
                                       style="width: 5rem;"
                                       type="number" name="dPercentage" id="checkDiscountPercent"
                                       value=0 min="0" max="100"><label>%</label>
                            </div>

                            <div class="d-none" id="discountForPrice">
                                <label>RS</label><input class="text-center p-1 m-1"
                                                        style="width: 5rem;"
                                                        type="number" name="dAmount" id="checkDiscountAmount"
                                                        value=0>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex m-3">
                    <input type="checkbox" name="vat" id="vet">
                    <label class="m-1">Vat 13%</label>
                </div>

                <div>
                    <label for="exampleInputPhone" class="form-label">Total Amount:</label>
                    <input type="number" name="totalBill" class="w-100" id="grandTotal" step="0.001"
                           oninput="this.value = Math.abs(parseFloat(this.value) || 0).toFixed(2)">
                </div>
                <div class="m-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>

@endsection
