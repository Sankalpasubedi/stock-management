@extends('layouts.app')
@section('body')
    <div class="row m-3">
        <div class="col-2"><a href="{{route('return')}}"> <label class="back rounded-2">Back</label></a>
        </div>
        <div class="col-10 d-flex justify-content-end">
            <label class="m-1">Search:</label>
            <form action="{{route('searchReturn')}}" method="get">
                <input class="m-1" type="text" name="searchReturn">
            </form>
        </div>
    </div>
    <div class="row m-3 d-flex bg-heading">
        <div class="col-2 text-center">Bill From</div>
        <div class="col-2 text-center">Name</div>
        <div class="col-2 text-center">Bill No</div>
        <div class="col-1 text-center">Amount</div>
        <div class="col-2 text-center">Remaining</div>
        <div class="col-2 text-center">EndDate</div>
        <div class="col-1 text-center">Actions</div>
    </div>
    @foreach($returns as $return)
        <div class="row m-2">
            <div class="col-2 text-center">
                {{$return->returnable_type}}

            </div>

            <div class="col-2 text-center">
                {{$return->returnable->name}}
            </div>

            <div class="col-2 text-center">
                {{$return->bill_no}}
            </div>


            <div class="col-1 text-center">
                {{$return->total_bill_amount}}
            </div>

            <div class="col-2 d-flex justify-content-center">
                @if($return->returnable_type === 'vendor')
                    @if($return->payable === null)
                        <label>Paid</label>
                    @else
                        <div class="d-flex justify-content-around">
                            {{$return->payable}}
                            <form id="payment" action="{{route('paidReturn',['id'=>$return->id])}}" method="post">
                                @csrf
                                @method('PATCH')
                                <button style="border:none;" onclick="return payment(event)" type="submit">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                @elseif($return->returnable_type === 'customer')
                    @if($return->receivable === null)
                        <label>Paid</label>
                    @else
                        <div class="d-flex justify-content-around">
                            {{$return->receivable}}
                            <form id="payment" action="{{route('paidReturn',['id'=>$return->id])}}" method="post">
                                @csrf
                                @method('PATCH')
                                <button style="border:none; margin-inline: 0.5rem;" onclick="return payment(event)"
                                        type="submit">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                @endif
            </div>
            <div class="col-2 text-center">
                @if($return->bill_end_date === null)
                    ---
                @endif
                {{$return->bill_end_date}}
            </div>

            <div class="col-1 d-flex">

                <form action="{{route('deleteReturned', ['id' => $return->id])}}" method="post">
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
            {{$returns->links('pagination::simple-tailwind')}}
        </div>
    </div>
@endsection
