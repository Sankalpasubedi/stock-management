@extends('layouts.app')
@section('body')
    <style>
        .bill {
            background-color: #F6F6F6;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin-right: auto;
            margin-left: auto;
        }

        .brand-section {
            background-color: #0d1033;
            padding: 10px 40px;
        }


        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-6 {
            width: 50%;
            flex: 0 0 auto;
        }

        .text-white {
            color: #fff;
        }

        .company-details {
            float: right;
            text-align: right;
        }

        .body-section {
            padding: 16px;
            border: 1px solid gray;
        }

        .heading {
            font-size: 20px;
            margin-bottom: 08px;
        }

        .sub-heading {
            color: #262626;
            margin-bottom: 05px;
        }

        table {
            background-color: #fff;
            width: 100%;
            border-collapse: collapse;
        }

        table thead tr {
            border: 1px solid #111;
            background-color: #f2f2f2;
        }

        table td {
            vertical-align: middle !important;
            text-align: center;
        }

        table th, table td {
            padding-top: 08px;
            padding-bottom: 08px;
        }

        .table-bordered {
            box-shadow: 0px 0px 5px 0.5px gray;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .text-right {
            text-align: end;
        }

        .w-20 {
            width: 20%;
        }

        .float-right {
            float: right;
        }
    </style>
    <div class="bill">
        <div class="container">
            <div class="brand-section">
                <div class="row">
                    <div class="col-6">
                        <h3 class="text-white">Name: {{$mainBill->billable->name}}</h3>
                    </div>
                    <div class="col-6 d-flex justify-content-end align-items-center">
                        <h5 class="text-white">Billed date/time: {{$mainBill->created_at}}</h5>
                    </div>
                </div>
            </div>

            <div class="body-section">
                <div class="row">
                    <div class="col-6 ">
                        <h6 class="sub-heading">Address: {{$mainBill->billable->address}}</h6>
                        <h6 class="sub-heading">Phone Number: {{$mainBill->billable->phone_no}}</h6>
                    </div>
                    <div class="col-6 text-end">
                        <h2 class="heading">Bill No.: {{$mainBill->bill_no}}</h2>
                    </div>
                </div>
            </div>

            <div class="body-section">
                <table class="table-bordered">

                    <thead>
                    <tr class="text-center">
                        <th>Product</th>
                        <th class="w-20">Price</th>
                        <th class="w-20">Quantity</th>
                        <th class="w-20">Total</th>
                    </tr>
                    </thead>

                    @foreach($subProducts as $subProduct)
                        <tbody>
                        <tr>
                            <td>{{$subProduct->product->name}}</td>
                            <td>{{$subProduct->rate}}</td>
                            <td>{{$subProduct->stock}}</td>
                            <td>{{$subProduct->total_product_amount}}</td>
                        </tr>
                        </tbody>
                    @endforeach
                    <tbody>
                    <tr>
                        <td colspan="3" class="text-right">Sub Total</td>
                        <td><input class="text-center p-1 m-1" type="number" disabled id="savedTotal"
                                   value="{{$total}}"></td>
                    </tr>
                    @if($mainBill->discount_percentage > 0)
                        <tr>
                            <td colspan="3" class="text-right">Discount <label>{{$mainBill->discount_percentage}}
                                    %</label>
                            </td>
                            <td><input class="text-center p-1 m-1" type="number" disabled name="discountPP"
                                       id="discountPP"
                                       value={{$discountAmt}}></td>
                        </tr>
                    @elseif($mainBill->discount_amount > 0)
                        <tr>
                            <td colspan="3" class="text-right">Discount
                            </td>
                            <td><input class="text-center p-1 m-1" type="number" disabled name="discountAA"
                                       id="discountAA"
                                       value={{$discountAmt}}></td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="3" class="text-right">Discount
                            </td>
                            <td><input class="text-center p-1 m-1" type="number" disabled name="discountAA"
                                       id="discountAA"
                                       value='0'></td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="3" class="text-right">Total Taxable Amount
                        </td>
                        <td class="text-center"><input class="text-center p-1 m-1" type="number" disabled name="vat"
                                                       value={{$taxableAmount}}
                                                           id="vat"></td>
                    </tr>
                    @if($mainBill->vat === 1)
                        <tr>
                            <td colspan="3" class="text-right">Vat 13%
                            </td>
                            <td class="text-center"><input class="text-center p-1 m-1" type="number" disabled name="vat"
                                                           value={{$vatAmt}}
                                                           id="vat"></td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="3" class="text-right">Grand Total</td>
                        <td class="text-center"><input class="text-center p-1 m-1" type="number" disabled
                                                       name="grandTotal"
                                                       value="{{$mainBill->total_bill_amount}}"
                                                       id="grandTotal"></td>
                    </tr>
                    </tbody>
                </table>
                <br>
            </div>

        </div>
    </div>

@endsection
