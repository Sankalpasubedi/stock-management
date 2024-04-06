@extends('layouts.app')
@section('body')

    <form action="{{route('saveProduct',['id'=>$product->id])}}" method="post">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1" value="{{$product->name}}">
            @if($errors->has('name'))
                <div class="error"> {{$errors->first('name')}}</div>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category">
                <option value="{{$product->category_id}}">{{$product->category->name}} </option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select><br>
            @if($errors->has('category'))
                <div class="error">{{$errors->first('category')}}</div>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Brand</label>
            <select name="brand">
                <option value="{{$product->brand_id}}">{{$product->brand->name}}</option>
                @foreach($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                @endforeach
            </select><br>
            @if($errors->has('brand'))
                <div class="error">{{$errors->first('brand')}} </div>
            @endif
        </div>


        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{$product->current_stock}}">
            @if($errors->has('stock'))
                <div class="error"> {{$errors->first('stock')}} </div>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Unit</label>
            <select name="unit">
                <option value="{{$product->unit_id}}">{{$product->unit->name}}</option>
                @foreach($units as $unit)
                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                @endforeach
            </select><br>
            @if($errors->has('unit'))
                <div class="error">{{$errors->first('unit')}}</div>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" value="{{$product->price}}">
            @if($errors->has('price'))
                <div class="error">{{$errors->first('price')}} </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
