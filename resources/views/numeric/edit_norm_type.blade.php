@extends('layouts.main')

@section('section-title', 'Normas - editar') 

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <div class="card border-0 rounded-0 shadow shadower">
                <div class="card-body">
                    {!! Form::model($normType, ['route' => ['put.norm.type', 'id_tipo_norma' => $normType->id_tipo_norma], 'method' => 'PUT', 'data-parsley-validate' => true, 'data-parsley-errors-messages-disabled' => true]) !!}
                        @csrf
                        <div class="row">
                            <div class="col-md-6 pr-1">
                                <div class="form-group">
                                    <label for="desc_tipo_norma">Descripción</label>
                                    <input type="text" class="form-control rounded-0" name="desc_tipo_norma" placeholder="AA CJ (Catamarca)" value="{{ $normType->desc_tipo_norma }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 pl-1">
                                <div class="form-group">
                                    <label for="id_tipo_norma">Abreviatura</label>
                                    <input type="text" class="form-control rounded-0" name="id_tipo_norma" placeholder="AACJCATA" value="{{ $normType->id_tipo_norma }}" required> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-1">
                                <div class="form-group">
                                    <label for="idjurisdiccion">Jurisdicción</label>
                                    <select name="idjurisdiccion" class="form-control rounded-0" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach ($jurisdictions as $juri)
                                            @if($juri->idjurisdiccion == $normType->idjurisdiccion)
                                                <option value="{{ $juri->idjurisdiccion }}" selected>{{ $juri->jurisdiccion }}</option>
                                            @else 
                                                <option value="{{ $juri->idjurisdiccion }}">{{ $juri->jurisdiccion }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 pl-1">
                                <div class="form-group">
                                    <label for="idtipodocumento">Tipo de documento</label>
                                    <select name="idtipodocumento" class="form-control rounded-0" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach ($tipodocs as $doc)
                                            @if($doc->idtipodocumento == $normType->idtipodocumento)
                                                <option value="{{ $doc->idtipodocumento }}" selected>{{ $doc->tipodocumento }}</option>
                                            @else 
                                                <option value="{{ $doc->idtipodocumento }}">{{ $doc->tipodocumento }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border_top rounded-0 bg-white">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-default bg-trivia rounded-pill text-light border-0 shadow-sm float-right">Modificar</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12 text-center">
            <a href="{{ url()->previous() }}"><i class="fas fa-2x fa-long-arrow-alt-left text-secondary"></i></a>
        </div>
    </div>
@stop
