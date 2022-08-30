@extends('layouts.ismart')
@section('content')
    <div id="main-content-wp" class="category-news-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="?page=home" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">{{$page->name}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="clearfix wp-inner">
            <div id="content" class="fl-left">
                {!!$page->content!!}
            </div>
        </div>
    </div>
@endsection