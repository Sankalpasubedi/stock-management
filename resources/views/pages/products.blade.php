@extends('layouts.app')
@section('body')
    <div class="row m-3">
        <div class="col-2"><a href="{{route('product')}}"> <label class="back rounded-2">Back</label></a>
        </div>
        <div class="col-10 d-flex justify-content-end">
            <label class="m-1">Search:</label>
            <form action="{{route('searchProduct')}}" method="get">
                <input class="m-1" type="text" name="searchProduct">
            </form>
        </div>
    </div>
    <div class="row m-3 bg-heading">
        <div class="col-2 text-center">Name</div>
        <div class="col-2 text-center">Category</div>
        <div class="col-2 text-center">Brand</div>
        <div class="col-1 text-center">Stock</div>
        <div class="col-2 text-center">Unit</div>
        <div class="col-1 text-center">Price</div>
        <div class="col-2 text-center">Actions</div>
    </div>
    @foreach($products as $product)
        <div class="row m-3">
            <div class="col-2 text-center">
                {{$product->name}}
            </div>
            <div class="col-2 text-center">
                {{$product->category->name ?? ''}}
            </div>
            <div class="col-2 text-center">
                {{$product->brand->name}}
            </div>
            <div class="col-1 text-center">
                {{$product->current_stock}}
            </div>
            <div class="col-2 text-center">
                {{$product->unit->name}}
            </div>
            <div class="col-1 text-center">
                {{$product->price}}
            </div>
            <div class="col-2 d-flex justify-content-center">
                <a class="" href="{{route('updateProduct',['id' =>$product->id])}}">
                    <i class="fas fa-edit"></i>
                </a>

                <form action="{{route('deleteProduct', ['id' => $product->id])}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </div>

        </div>
        <hr>
    @endforeach
    <div class="row">
        <div class="col-9"></div>
        <div class="col-3 text-end">
            {{$products->links('pagination::simple-tailwind')}}
        </div>
    </div>
    <div class="row text-center item">
        <a href="{{ route('addProduct') }}">
            <div class="col-12">
                <div class="fw-bold fs-2">
                    Add
                </div>
            </div>
        </a>
    </div>

@endsection
