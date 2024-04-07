@extends('layouts.app')
@section('body')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>404 Error Page</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><b>Dashboard</b></a></li>
                        <li class="breadcrumb-item active"><b>404 Error Page</b></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="error-page">
                <h2 class="headline text-warning"> 404</h2>

                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

                    <p>
                        We could not find the page you were looking for.
                        Meanwhile, you may <a href="{{url('/')}}">return to Bills</a> or try using the search
                        form.
                    </p>
                    {{--<p><strong>{{ $error_code }}</strong></p>--}}
                    <!-- /.input-group -->

                </div>
                <!-- /.error-content -->
            </div>

        </div><!-- /.container-fluid -->
    </section>

@endsection
