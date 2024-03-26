@extends('layouts.app')
@section('body')

    <form action ="{{route('createBrand')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Brand Name</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1" >
            @if($errors->has('name')) <div class="error">{{$errors->first('name')}}</div> @endif
        </div><div class="mb-3">
            <label for="exampleInputAddress" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="exampleInputAddress" >
            @if($errors->has('address'))<div class="error"> {{$errors->first('address')}}</div> @endif
        </div><div class="mb-3">
            <label for="exampleInputPhone" class="form-label">Phone Number</label>
            <input type="text" name="phone_no" class="form-control" id="exampleInputPhone" >
            @if($errors->has('phone_no')) <div class="error">{{$errors->first('phone_no')}} </div>@endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
