@php use function PHPUnit\Framework\isEmpty;use function PHPUnit\Framework\isNull; @endphp
@extends('layouts.watches')
@section('title', "Каталог")
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumbs-main">
                <ol class="breadcrumb">
                    @if($breadCrumbs)
                        {!! $breadCrumbs !!}
                    @else
                        <li><a href="{{route("main.index")}}">Главная</a></li>
                    @endif

                    @if($searchQuery)
                            <li>Поиск по запросу "{{$searchQuery}}"</li>
                    @endif
                </ol>
            </div>
        </div>
    </div>
    @include('catalog.partial')
@endsection
