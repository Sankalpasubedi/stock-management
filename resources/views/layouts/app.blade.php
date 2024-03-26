@include('layouts.header')
@include('layouts.sidebar')
<div class="content-wrapper bg-background">
    <section class="content">
        <div class="container-fluid">
            <div class="box">
                @yield('body')
            </div>
        </div><!-- /.container-fluid -->
    </section>

</div>
@include('layouts.footer')
