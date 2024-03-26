@extends('layouts.app')
@section('body')

    <form action="{{route('saveSales',['id'=>$bill->id,'stock'=>$stock])}}" method="post">
        @csrf
        @method('PATCH')
        <div class="m-3">
            <div class="row mb-1">
                <label for="exampleInputEmail1" class="col-1 form-label">Product</label>
                <select class="col-2" name="product">
                    @foreach($products as $product)
                        @if($product->id === $bill->product_id)
                            <option value="{{$product->id}}">{{$product->name}}::{{$product->current_stock}} </option>
                        @endif
                    @endforeach
                    @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}::{{$product->current_stock}}</option>
                    @endforeach
                </select>
                @if($errors->has('product'))
                    <div class="error">{{$errors->first('product')}}</div>
                @endif
                <label class="col-1">Stock</label><input class="col-2" id="stockPurchase" type="number"
                                                         value="{{$bill->stock}}"
                                                         name="stock">
                @if(session('message'))
                    {{session('message')}}
                @endif
                @if($errors->has('stock'))
                    <div class="error">{{$errors->first('stock')}}</div>
                @endif
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleInputAddress" class="form-label">Rate</label>
            <input type="number" name="rate" value="{{$bill->rate}}" class="form-control"
                   id="ratePurchase">
            @if($errors->has('total'))
                <div class="error"> {{$errors->first('total')}}</div>
            @endif
        </div>


        <div class="mb-3">
            <label for="exampleInputAddress" class="form-label">Price</label>
            <input type="number" name="total" id="totalPurchase" class="form-control" readonly
                   value="{{$bill->total_product_amount}}">
            @if($errors->has('total'))
                <div class="error"> {{$errors->first('total')}}</div>
            @endif
        </div>
        <div class="row m-3">
            <div class="text-center col-6 bg-red fs-5 rounded rounded-pill">
                @foreach($errors->all() as $error)
                    {{$error}}
                @endforeach
            </div>
        </div>

        <div class="row m-2">
            <div class="col-2">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
        </div>
    </form>
    <div class="row m-2">
        <div class="col-2">
            <form action="{{route('deleteSubBillSales', ['id' => $bill->id])}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn bg-red w-100">
                    Delete
                </button>
            </form>
        </div>
    </div>
@endsection
