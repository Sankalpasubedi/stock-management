@extends('layouts.app')
@section('body')

    <form action ="{{route('createUnit')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Unit Name</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1" >
                @if($errors->has('name'))  <div class="error"> {{$errors->first('name')}} </div>@endif
        <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
