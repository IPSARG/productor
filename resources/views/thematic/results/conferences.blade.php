@extends('layouts.main')

@section('section-title', 'Índice temático') 

@section('content')
    <div class="row">
        <div class="col-md-12 mt-4 mb-2">
            @include('partials._breadcrumbs')
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-10 offset-md-1">
            @php $prevDescimp =  ''; $prevDate =  ''; @endphp
            @foreach ($tematics as $tematic)
            {{-- {{ dd($tematic) }} --}}
                <div class="card border-0 rounded-0 shadow-sm mb-2">
                    @php $lvl = isset($lvl) ? $lvl : 0; @endphp
                    @if($tematic->mes . $tematic->anio !== $prevDate || $tematic->mes . $tematic->anio == $prevDate && $tematic->descimpuesto !== $prevDescimp)
                        {{-- DESCTIPODOC --}}
                        <div class="card-header bg-lightgrey rounded-0 border-0 py-1" data-count="{{$lvl}}" data-nivel={{$lvl}} data-group="group_{{$lvl}}">
                            <p class="m-0 text-dark font-weight-bold py-1">{{$tematic->desctipodoc}} <span class="badge badge-pill bg-orange text-white float-right mt-1">{{$tematic->mes}}-{{$tematic->anio}}</span></p>
                        </div>
                    @endif
                    <div class="card-body py-2">
                        {{-- LINK HTML --}}
                        <a class="text-reset" href="{{$tematic->nombredochtm}}" target="_blank">
                            {{$tematic->descripcion}}
                        </a>
                        @php 
                            $prevDescimp = $tematic->descimpuesto; 
                            $prevDate = $tematic->mes . $tematic->anio; 
                        @endphp
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop