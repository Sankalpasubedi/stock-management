@extends('layouts.app')
@section('body')
    <div class="row m-3">
        <div class="col-2"><a href="{{route('customer')}}"> <label class="back rounded-2">Back</label></a>
        </div>
        <div class="col-10 d-flex justify-content-end">
            <label class="m-1">Search:</label>
            <form action="{{route('searchCustomer')}}" method="get">
                <input class="m-1" type="text" name="searchCustomer">
            </form>
        </div>
    </div>
    <div class="row m-3 bg-heading">
        <div class="col-3 text-center">Name</div>
        <div class="col-3 text-center">Address</div>
        <div class="col-3 text-center">Phone Number</div>
        <div class="col-3 text-center">Actions</div>
    </div>
    @foreach($customers as $customer)
        <div class="row m-3">
            <div class="col-3 text-center">
                {{$customer->name}}
            </div>
            <div class="col-3 text-center">
                {{$customer->address}}
            </div>
            <div class="col-3 text-center">
                {{$customer->phone_no}}
            </div>
            <div class="col-3 d-flex justify-content-center">
                <a class="" href="{{route('updateCustomer',['id' =>$customer->id])}}">
                    <i class="fas fa-edit"></i>
                </a>


                <form action="{{route('deleteCustomer', ['id' => $customer->id])}}" method="post">
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
            {{$customers->links('pagination::simple-tailwind')}}
        </div>
    </div>
    <div class="row item text-center">
        <a href="{{ route('addCustomer') }}">
            <div class="col-12">
                <div class="fw-bold fs-2">
                    Add
                </div>
            </div>
        </a>
    </div>

@endsection
