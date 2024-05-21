@extends('frontend.layouts.app')

@section('content')
    <section class="mb-5" style="margin-top: 2rem;">
        <div class="container">
            <!-- Banner -->
            @if (get_setting('todays_deal_banner') != null || get_setting('todays_deal_banner_small') != null)
                <div class="mb-4 overflow-hidden hov-scale-img d-none d-md-block">
                    <img src="{{ asset('assets/img/placeholder-rect.jpg') }}"
                        data-src="{{ uploaded_asset(get_setting('todays_deal_banner')) }}"
                        alt="{{ env('APP_NAME') }} promo" class="lazyload img-fit h-100 has-transition"
                        onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder-rect.jpg') }}';">
                </div>
                <div class="mb-4 overflow-hidden hov-scale-img d-md-none">
                    <img src="{{ asset('assets/img/placeholder-rect.jpg') }}"
                        data-src="{{ get_setting('todays_deal_banner_small') != null ? uploaded_asset(get_setting('todays_deal_banner_small')) : uploaded_asset(get_setting('todays_deal_banner')) }}"
                        alt="{{ env('APP_NAME') }} promo" class="lazyload img-fit h-100 has-transition"
                        onerror="this.onerror=null;this.src='{{ asset('assets/img/placeholder-rect.jpg') }}';">
                </div>
            @endif
            <!-- Products Section -->
            <div class="px-3">
                <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-2 gutters-16">
                    @foreach ($todays_deal_products as $key => $product)
                        <div class="col text-center z-1 p-2 p-lg-3">
                            @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
