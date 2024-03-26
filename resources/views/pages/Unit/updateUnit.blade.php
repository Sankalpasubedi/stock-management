@extends('layouts.app')
@section('body')

    <form action ="{{route('saveUnit',['id'=>$unit->id])}}" method="post">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Unit Name</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1" value="{{$unit->name}}">
                @if($errors->has('name'))<div class="error"> {{$errors->first('name')}}</div> @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

