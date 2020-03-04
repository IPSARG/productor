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
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <div class="card border-0 rounded-0 shadow shadower">
                <div class="card-header bg-dark text-light rounded-0 border-0">
                    <p class="m-0">Agregar nodo a: <strong>{{ $desc_nodo }}</strong></p>
                </div>
                <div class="card-body">
                    <form action="{{ route('link.norm') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cod_padre" value="{{ $cod_nodo }}">
                        <div class="form-group">
                            <label for="id_norma">Código de norma</label>
                            <input type="text" class="form-control rounded-0 form-control-lg" aria-describedby="button-addon2" name="id_norma" placeholder="ej. 134/19">
                        </div>
                        <div class="row">
                            <div class="col pr-1">
                                <div class="form-group">
                                    <label for="id_tipo_norma">Abreviatura</label>
                                    <select name="id_tipo_norma" class="form-control rounded-0 form-control-lg">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($normTypes as $normType)
                                            <option value="{{ $normType->id_tipo_norma }}">{{ $normType->id_tipo_norma }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col pl-1">
                                <div class="form-group">
                                    <label for="articulo">Articulo</label>
                                    <input type="text" class="form-control rounded-0 form-control-lg" aria-describedby="button-addon2" name="articulo" placeholder="ej. 9">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border_top rounded-0 bg-white">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-success rounded-pill border-0 px-4 shadow-green-left float-right">Vincular</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12 text-center">
            <a href="{{ url()->previous() }}"><i class="fas fa-2x fa-long-arrow-alt-left text-secondary"></i></a>
        </div>
    </div>
@stop