@extends('layouts.app')
@section('body')

    <form action="{{route('savePurchase',['id'=>$bill->id,'stock'=>$stock])}}" method="post">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Product</label>
            <select name="product">
                <option value="{{$bill->product->id}}">{{$bill->product->name}} </option>
                @foreach($products as $product)
                    <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>
            @if($errors->has('product'))
                <div class="error">{{$errors->first('product')}}</div>
            @endif
            <label>Stock</label><input type="number" id="stockPurchase" value="{{$bill->stock}}" name="stock">
            @if($errors->has('stock'))
                <div class="error">{{$errors->first('stock')}}</div>
            @endif
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
            <label for="exampleInputAddress" class="form-label">Total</label>
            <input type="number" name="total" readonly value="{{$bill->total_product_amount}}"
                   class="form-control"
                   id="totalPurchase">
            @if($errors->has('total'))
                <div class="error"> {{$errors->first('total')}}</div>
            @endif
        </div>


        <div class="row m-2">
            <div class="col-2">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
        </div>
    </form>
    <div class="row m-2">
        <div class="col-2">
            <form action="{{route('deleteSubBill', ['id' => $bill->id])}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn bg-red w-100">
                    Delete
                </button>
            </form>
        </div>
    </div>
@endsection
