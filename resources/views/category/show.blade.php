@php use function PHPUnit\Framework\isEmpty;use function PHPUnit\Framework\isNull; @endphp
@extends('layouts.watches')
@section('title', $categoryTitle)
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumbs-main">
                <ol class="breadcrumb">
                    {!! $breadCrumbs !!}
                </ol>
            </div>
        </div>
    </div>
    @include('products.indexPartial')
@endsection
