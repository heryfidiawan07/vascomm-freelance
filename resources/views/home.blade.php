@extends('layouts.admin')

@section('content')
<div class="page-body">
    @include('partials.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            @for($i=0; $i<8; $i++)
                <div class="col-md-3 px-1">
                    <div class="card pb-3">
                        <div class="img-frame mb-2 text-center" style="height: 150px; overflow: hidden; display: flex; justify-content: center;">
                            <img src="{{ asset('assets/images/ecommerce/card.png') }}" alt="majoo" class="product-img" style="max-width: 100%;">
                        </div>
                        <h5 class="text-center">Title Product</h5>
                        <p class="text-center mt-2 mb-0">Rp<b class="ml-2">1.500.000</b></p>
                        <div class="p-3 mb-4" style="height: 4em; overflow-y: hidden;">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        </div>
                        <div class="text-center">
                            <button class="btn btn-success btn-sm px-3">Beli</button>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
@endsection
