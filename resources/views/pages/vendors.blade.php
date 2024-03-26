@extends('layouts.app')
@section('body')
    <div class="row m-3">
        <div class="col-2"><a href="{{route('vendor')}}"> <label class="back rounded-2">Back</label></a>
        </div>
        <div class="col-10 d-flex justify-content-end">
            <label class="m-1">Search:</label>
            <form action="{{route('searchVendor')}}" method="get">
                <input class="m-1" type="text" name="searchVendor">
            </form>
        </div>
    </div>
    <div class="row m-3 bg-heading">
        <div class="col-3 text-center">Name</div>
        <div class="col-3 text-center">Address</div>
        <div class="col-3 text-center">Phone Number</div>
        <div class="col-3 text-center">Actions</div>
    </div>
    @foreach($vendors as $vendor)
        <div class="row m-3">
            <div class="col-3 text-center">
                {{$vendor->name}}
            </div>
            <div class="col-3 text-center">
                {{$vendor->address}}
            </div>
            <div class="col-3 text-center">
                {{$vendor->phone_no}}
            </div>
            <div class="col-3 d-flex justify-content-center">
                <a class="" href="{{route('updateVendor',['id' =>$vendor->id])}}">
                    <i class="fas fa-edit"></i>
                </a>


                <form action="{{route('deleteVendor', ['id' => $vendor->id])}}" method="post">
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
            {{$vendors->links('pagination::simple-tailwind')}}
        </div>
    </div>
    <div class="row text-center item">
        <a href="{{ route('addVendor') }}">
            <div class="col-12">
                <div class="fw-bold fs-2">
                    Add
                </div>
            </div>
        </a>
    </div>

@endsection
