@extends('site.layout.site')

@section('title', 'Cảm ơn bạn đã mua thuốc theo toa (đơn)')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')

    <section class="main-ctn">
        <div class="wrapper container">

            <div class="breadcrumbs">
                <div class="wrapper">
                    <ul>
                        <li class="breadcrumb-item">
                            <a class="home" href="">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a itemprop="url" href="" title="Đăng nhập"><span itemprop="title">{{ $post->title }}</span></a>
                        </li>
                    </ul>
                </div>
            </div><!--end: .breadcrumbs-->

            <section id="">
                <div class="">
                    <h1 class="title_contact" style="margin-bottom: 15px;">{{ $post->title }}</h1>
                    <div class="contact-info col-xs-12 col-xs-offset-0 col-md-offset-2 col-md-10 col-lg-8 col-lg-offset-2">
						{!! $post->content !!}
                    </div><!--end: .contact-info-->
                </div>
            </section><!--end: #content-->
        </div>
    </section>

@endsection
