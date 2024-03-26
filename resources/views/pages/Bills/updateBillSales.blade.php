@extends('layouts.app')
@section('body')

    <form action="{{route('saveBillSales',['id'=>$bill->id])}}" method="post" id="formStart">
        @csrf
        @method('PATCH')
        <div class="m-3">
            <div class="row">
                <div class="col-2 fw-bold fs-5">
                    Vendor name:
                </div>
                <div class="col-4 fw-bold fs-5">
                    <div class="vendor">
                        <select name="customer[]" class="w-100 text-center" required>
                            <option value="{{$bill->billable->id}}">{{$bill->billable->name}}</option>
                            @foreach($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row m-3 d-flex bg-heading">
                    <div class="col-4 text-center">Product Name</div>
                    <div class="col-3 text-center">Rate</div>
                    <div class="col-2 text-center">Quantity</div>
                    <div class="col-2 text-center">Price</div>
                    <div class="col-1 text-center">Actions</div>
                </div>
            </div>
            <div class="m-2" id="copyFrom">
                <div class="item-form">
                    @foreach($subBills as $subBill)
                        <div class="row m-3">
                            <div class="col-4">
                                <select name="product[]" class="w-100 text-center" disabled required>
                                    <option value="{{$subBill->product_id}}">{{$subBill->product->name}}</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3 text-center">
                                <div class="price">
                                    <input type="number" value="{{$subBill->rate}}" class="w-100 text-center"
                                           id="pricePP" disabled
                                           required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="stock">
                                    <input type="number" name="stock[]" value="{{$subBill->stock}}"
                                           class="w-100 text-center" disabled
                                           id="stockPP" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="total">
                                    <input type="number" name="total[]" disabled
                                           value="{{$subBill->total_product_amount}}"
                                           class="w-100 text-center" id="totalPP"
                                           required>
                                </div>
                            </div>
                            <div class="col-1 text-center">

                                <a href="{{ route('updateSales', ['id' => $subBill->id, 'stock' => $subBill->stock, 'price' => $subBill->total_product_amount]) }}">
                                    <i class="fas fa-edit"></i>
                                </a>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="m-3" id="copyTo">

        </div>


        <div class="row m-3">
            <label for="exampleInputPhone" class="form-label">Bill Number</label>
            <input type="text" name="billNum" value="{{$bill->bill_no}}" class="form-control w-100"
                   id="exampleInputPhone">
        </div>
        <div class="row m-3">
            <label for="exampleInputPhone" class="form-label">Total Amount:</label>
            <input type="number" name="totalBill" value="{{$bill->total_bill_amount}}" disabled
                   class="form-control w-100"
                   id="totalBill">
        </div>
        <div class="m-3">
            <label id="purchase" onclick="purchase()" class="bg-primary rounded-2 p-1 m-1 bHover">Credit
                Purchase</label>
            <div class="mb-3 @if($bill->receivable <= 0) d-none @endif" id="creditPurchaseContent">
                <div class="row">
                    <div class="col-5">
                        <label for="exampleInputAddress" class="">Credit Price</label>
                        <input type="number" name="receivable" value="{{$bill->receivable}}" class="form-control"
                               id="exampleInputAddress">
                    </div>
                    <div class="col-7">
                        <label for="exampleInputPhone" class="form-label">Payment Date</label>
                        <input type="date" name="date" value="{{$bill->bill_end_date}}" class="form-control"
                               id="exampleInputPhone">
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

@endsection
