@extends('layouts.app')
@section('body')
    <div class="row m-3">
        <div class="col-2"><a href="{{route('unit')}}"> <label class="back rounded-2">Back</label></a>
        </div>
        <div class="col-10 d-flex justify-content-end">
            <label class="m-1">Search:</label>
            <form action="{{route('searchUnit')}}" method="get">
                <input class="m-1" type="text" name="searchUnit">
            </form>
        </div>
    </div>
    <div class="row m-3 bg-heading">
        <div class="col-6 text-center">Name</div>
        <div class="col-6 text-center">Actions</div>
    </div>
    @foreach($units as $unit)
        <div class="row m-3">
            <div class="col-6 text-center">
                {{$unit->name}}
            </div>
            <div class="col-6 d-flex justify-content-center">
                <a class="" href="{{route('updateUnit',['id' =>$unit->id])}}">
                    <i class="fas fa-edit"></i>
                </a>


                <form action="{{route('deleteUnit', ['id' => $unit->id])}}" method="post">
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
            {{$units->links('pagination::simple-tailwind')}}
        </div>
    </div>
    <div class="row text-center item">
        <a href="{{ route('addUnit') }}">
            <div class="col-12">
                <div class="fw-bold fs-2">
                    Add
                </div>
            </div>
        </a>
    </div>

@endsection
