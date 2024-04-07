@extends('layouts.app')
@section('body')
    <div class="row m-3">
        <div class="col-12 text-end">
            @foreach($errors->all() as $error)
                @foreach($error as $message)
                    {{$message}}
                @endforeach
            @endforeach
        </div>
    </div>
    <div class="row m-3">
        <div class="col-2"><a href="{{route('category')}}"> <label class="back rounded-2">Back</label></a>
        </div>
        <div class="col-10 d-flex justify-content-end">
            <label class="m-1">Search:</label>
            <form action="{{route('searchCategory')}}" method="get">
                <input class="m-1" type="text" name="searchCategory">
            </form>
        </div>
    </div>
    <div class="container">
        <div class="row m-3 bg-heading">
            <div class="col-6 text-center">Name</div>
            <div class="col-6 text-center">Actions</div>
        </div>
        @foreach($categories as $category)
            <div class="row m-3">
                <div class="col-6 text-center">
                    {{$category->name}}
                </div>
                <div class="col-6 text-start d-flex justify-content-center">
                    <label class="bg-edit rounded-2">
                        <a class="" href="{{route('updateCategory',['id' =>$category->id])}}">
                            <i class="fas fa-edit"></i>
                        </a>
                    </label>


                    <form action="{{route('deleteCategory', ['id' => $category->id])}}" method="post">
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
                {{$categories->links('pagination::simple-tailwind')}}
            </div>
        </div>
        <div class="row item">
            <a href="{{ route('addCategory') }}">
                <div class="col-12 text-center">
                    <div class="fw-bold fs-2">
                        Add
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
