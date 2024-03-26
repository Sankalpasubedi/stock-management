@extends('layouts.app')
@section('body')
    <div class="row m-3">
        <div class="col-2"><a href="{{route('bill')}}"> <label class="back rounded-2">Back</label></a>
        </div>
        <div class="col-10 d-flex justify-content-end">
            <label class="m-1">Search:</label>
            <form action="{{route('searchBill')}}" method="get">
                <input class="m-1" type="text" name="searchBill">
            </form>
        </div>
    </div>
    <div class="row m-2 d-flex bg-heading">
        <div class="col-1 text-center">From</div>
        <div class="col-2 text-center">Name</div>
        <div class="col-2 text-center">Bill No</div>
        <div class="col-1 text-center">Amount</div>
        <div class="col-2 text-center">Remaining</div>
        <div class="col-2 text-center">EndDate</div>
        <div class="col-1 text-center">Actions</div>
        <div class="col-1 text-center"></div>
    </div>
    @foreach($bills as $bill)
        <div class="row m-3 ">
            <div class="col-1 text-center">
                {{$bill->billable_type}}<br>

            </div>

            <div class="col-2 text-center">
                {{$bill->billable->name}}
            </div>

            <div class="col-2 text-center preview">
                <a
                    href="{{route('previewBill',['id'=>$bill->id])}}">{{$bill->bill_no}}</a>
            </div>


            <div class="col-1 text-center">
                {{$bill->total_bill_amount}}
            </div>

            <div class="col-2 d-flex justify-content-center">
                @if($bill->billable_type === 'vendor')
                    @if($bill->payable === null)
                        <label>Paid</label>
                    @else
                        <div class="d-flex justify-content-around">
                            {{$bill->payable}}
                            <form id="payment" action="{{route('paidBill',['id'=>$bill->id])}}" method="post">
                                @csrf
                                @method('PATCH')
                                <button style="border:none;" onclick="return payment(event)" type="submit">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                @elseif($bill->billable_type === 'customer')
                    @if($bill->receivable === null)
                        <label>Paid</label>
                    @else
                        <div class="d-flex justify-content-around">
                            {{$bill->receivable}}
                            <form id="payment" action="{{route('paidBill',['id'=>$bill->id])}}" method="post">
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
                @if($bill->bill_end_date === null)
                    ---
                @endif
                {{$bill->bill_end_date}}
            </div>

            <div class="col-1 d-flex justify-content-around">

                @if($bill->billable_type === 'vendor')
                    <a href="{{route('updateBillPurchase',['id' =>$bill->id])}}">
                        <i class="fas fa-edit"></i>
                    </a>
                @elseif($bill->billable_type === 'customer')
                    <a href="{{route('updateBillSales',['id' =>$bill->id])}}">
                        <i class="fas fa-edit"></i>
                    </a>
                @endif
                <form action="{{route('deleteBill', ['id' => $bill->id])}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>


            </div>
            <div class="col-1 text-center d-grid">
                <form action="{{route('returnProduct',['id'=>$bill->id])}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="border-0 p-1 bg-primary rounded-pill" onclick="return payment(event)">
                        Return
                    </button>
                </form>

            </div>
        </div>
        <hr>

    @endforeach
    <div class="row">
        <div class="col-9"></div>
        <div class="col-3 text-end">
            {{$bills->links('pagination::simple-tailwind')}}
        </div>
    </div>
    <div class="row m-3">
        <div class="text-center col-6 bg-red fs-6 rounded rounded-pill">
            @foreach($errors->all() as $error)
                {{$error}}
            @endforeach
        </div>
    </div>

    <div class="row d-flex text-center">
        <div class="col-5 item itemBill">
            <a href="{{ route('addPurchase') }}">
                <div class="fw-bold fs-2">
                    Purchase
                </div>
            </a>
        </div>
        <div class="col-2"></div>
        <div class="col-5 item itemBill">
            <a href="{{ route('addSales') }}">
                <div class="fw-bold fs-2">
                    Sales
                </div>
            </a>
        </div>
    </div>

@endsection
