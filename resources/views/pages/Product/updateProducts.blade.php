@extends('layouts.app')
@section('body')

    <form action ="{{route('saveProduct',['id'=>$product->id])}}" method="post">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1" value="{{$product->name}}">
                @if($errors->has('name'))<div class="error"> {{$errors->first('name')}}</div> @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category">
                @foreach($categories as $category) @if($category->id === $product->category_id)<option value="{{$product->category_id}}">{{$category->name}} </option> @endif @endforeach
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select><br>
                @if($errors->has('category')) <div class="error">{{$errors->first('category')}}</div> @endif
        </div><div class="mb-3">
            <label class="form-label">Brand</label>
            <select name="brand">
                @foreach($brand as $brands) @if($brands->id === $product->brand_id)<option value="{{$product->brand_id}}">{{$brands->name}}</option> @endif @endforeach
                @foreach($brand as $brands)
                    <option value="{{$brands->id}}">{{$brands->name}}</option>
                @endforeach
            </select><br>
                @if($errors->has('brand')) <div class="error">{{$errors->first('brand')}} </div>@endif
        </div>


        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{$product->current_stock}}">
                @if($errors->has('stock'))<div class="error"> {{$errors->first('stock')}} </div>@endif
        </div>

        <div class="mb-3">
            <label class="form-label">Unit</label>
            <select name="unit">
                @foreach($unit as $units) @if($units->id === $product->unit_id) <option value="{{$product->unit_id}}">{{$units->name}}</option> @endif @endforeach
                @foreach($unit as $units)
                    <option value="{{$units->id}}">{{$units->name}}</option>
                @endforeach
            </select><br>
                @if($errors->has('unit')) <div class="error">{{$errors->first('unit')}}</div> @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" value="{{$product->price}}">
                @if($errors->has('price')) <div class="error">{{$errors->first('price')}} </div>@endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
