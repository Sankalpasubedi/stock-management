@extends('layouts.app')
@section('body')

    <form action="{{route('createProduct')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1">

            @if($errors->has('name'))
                <div class="error"> {{$errors->first('name')}}</div>
            @endif

        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category">
                <option value="{{null}}">Select</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select><br>
            @if($errors->has('category'))
                <div class="error"> {{$errors->first('category')}}</div>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Brand</label>
            <select name="brand">
                <option value="{{null}}">Select</option>
                @foreach($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                @endforeach
            </select><br>
            @if($errors->has('brand'))
                <div class="error"> {{$errors->first('brand')}}</div>
            @endif
        </div>


        <div class="mb-3">
            <label class="form-label">Unit</label>
            <select name="unit">
                <option value="{{null}}">Select</option>
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
            <input type="number" name="price" class="form-control">
            @if($errors->has('price'))
                <div class="error"> {{$errors->first('price')}} </div>
            @endif

        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
