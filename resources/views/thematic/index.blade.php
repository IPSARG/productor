@extends('layouts.main')

@section('section-title', 'Materias y Coes') 

@section('content')
    @if(session()->has('arrayDescNodo'))
        <div class="row">
            <div class="col-md-12 mt-4 mb-2">
                @include('partials._breadcrumbs')
            </div>
        </div>
    @endif
    @if(Request::get('Prim') || Route::is('tem'))
        <div class="row mt-3 mb-4">
            <div class="col-11">
                <a href="" class="btn btn-link rounded-circle bg-success shadow float-right" data-toggle="modal" data-target="#firstNode">
                    <i class="fas fa-2x fa-plus text-white pt-1"></i>
                </a>
            </div>
        </div>
        @include('thematic.modals.addFirstNode')
    @endif
    <div class="row mb-4">
        <div class="col-10 offset-md-1">
            @foreach ($tematics as $tematic)
                <div class="card border-0 rounded-0 shadow mb-2">
                    <div class="card-body bg-white text-dark py-2">
                        @if(IsCoefi::isCoefi(request(), $tematic->desc_nodo))
                            <a href="{{ route('get.tem.child.coe') . '?CodNodo=' . $tematic->cod_hijo . '&DescNodo=' . $tematic->desc_nodo }}" class="text-reset font-weight-bold text-decoration-none">{{ $tematic->desc_nodo }}</a>
                        @else 
                            <a href="{{ route('get.tem.child') . '?CodNodo=' . $tematic->cod_nodo . '&DescNodo=' . $tematic->desc_nodo }}" class="text-reset font-weight-bold text-decoration-none">{{ $tematic->desc_nodo }}</a>
                        @endif
                        @if($tematic->desc_nodo != 'Conferencias')
                            <ul class="list-inline float-right mb-0">
                                <li class="list-inline-item">
                                    <a href="" data-toggle="modal" data-target="#interNode_{{ IsCoefi::isCoefi(request(), $tematic->desc_nodo) ? $tematic->cod_hijo : $tematic->cod_nodo }}">
                                        <i class="fas fa-plus-circle text-success"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="" data-toggle="modal" data-target="#editNode_{{ IsCoefi::isCoefi(request(), $tematic->desc_nodo) ? $tematic->cod_hijo : $tematic->cod_nodo }}">
                                        <i class="fas fa-edit text-info"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    @if(IsCoefi::isCoefi(request(), $tematic->desc_nodo))
                                        <a href="{{ route('get.post.coe', ['cod_padre' => $tematic->cod_hijo, 'desc_nodo' => $tematic->desc_nodo]) }}"><i class="fas fa-link text-orange"></i></a>
                                    @else 
                                        <a href="{{ route('get.link.norm', ['cod_nodo' => $tematic->cod_nodo, 'desc_nodo' => $tematic->desc_nodo]) }}"><i class="fas fa-link text-secondary"></i></a>
                                    @endif
                                </li>
                                <li class="list-inline-item">
                                    <form action="{{ route('delete.node', IsCoefi::isCoefi(request(), $tematic->desc_nodo) ? $tematic->cod_hijo : $tematic->cod_nodo) }}" method="POST" class="conf_form">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-link p-0" type="submit">
                                            <i class="fas fa-trash-alt text-danger"></i>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
                @include('thematic.modals.addInterNode')
                @include('thematic.modals.editNode')
            @endforeach
        </div>
    </div>
@stop