@extends('layouts.main')

@section('section-title', 'Materias y Coes') 

@section('content')
    <div class="row">
        <div class="col-md-12 mt-4 mb-2">
            @include('partials._breadcrumbs')
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-10 offset-md-1">
            @foreach ($tematics as $norm)
                <div class="card border-0 rounded-0 shadow mb-2">
                    <div class="card-body bg-white text-dark py-2">
                        <div class="row">
                            <div class="col-md-2 pr-1">
                                <p class="m-0"><strong>{{ $norm->id_norma }}</strong></p>
                            </div>
                            <div class="col-md-8 px-1">
                                <p class="m-0">{{ str_limit($norm->desc_norma, 200, ' ...') }}</p>
                            </div>
                            <div class="col-md-2 pl-1">
                                <ul class="list-inline float-right mb-0">
                                    <li class="list-inline-item">
                                        <a href="{{ route('get.put.norm',['id_norma' => $norm->id_norma, 'id_tipo_norma' => $norm->id_tipo_norma, 'fromTem' => true]) }}">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>
                                    </li>
                                    @if(!Route::is('get.disp.NCl'))
                                        <li class="list-inline-item">
                                            <form action="{{ route('unlink.node', ['id_norma' => $norm->id_norma, 'id_tipo_norma' => $norm->id_tipo_norma])}}" method="post">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <input type="hidden" name="cod_nodo" value="{{ request()->get('CodNodo') }}">
                                                <button type="submit" class="btn btn-link p-0"><i class="fas fa-unlink text-secondary"></i></button>
                                            </form>
                                        </li>
                                    @endif
                                    <li class="list-inline-item">
                                        <form action="{{ route('delete.norm', ['id_norma' => $norm->id_norma, 'id_tipo_norma' => $norm->id_tipo_norma])}}" method="post" class="conf_form">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <input type="hidden" name="cod_nodo" value="{{ request()->get('CodNodo') }}">
                                            <button type="submit" class="btn btn-link p-0"><i class="fas fa-trash-alt text-danger"></i></button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- @include('thematic.modals.editNorm') --}}
            @endforeach
        </div>
    </div>
    <div class="d-flex flex-row justify-content-center align-items-center">
        {{ $tematics->appends(Request::except('page'))->links() }}
    </div>
@stop