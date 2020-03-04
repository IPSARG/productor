@extends('layouts.main')

@section('section-title', 'Tipo de norma - resultado de búsqueda') 

@section('content')
    <div class="row mt-3">
        <div class="col-md-10 offset-md-1">
            @if(count($normTypes) > 0)
                <h5 class="pb-2">Se econtraron <strong class="text-secondary">{{ count($normTypes) }}</strong> resultados</h5>
                <table class="table table-striped mb-0 shadow">
                    <thead class="border-0 bg-trivia text-white">
                        <tr>
                            <th class="border-0">Descipción</th>
                            <th class="border-0 text-center">Abreviatura</th>
                            <th class="border-0 text-center">jurisdicción</th>
                            <th class="border-0 text-center">Tipo documento</th>
                            <th colspan="2" class="border-0 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($normTypes as $normType)
                            <tr>
                                <td>{{ $normType->desc_tipo_norma }}</td>
                                <td class="text-center">{{ $normType->id_tipo_norma }}</td>
                                <td class="text-center">{{ $normType->j_acr }}</td>
                                <td class="text-center">{{ $normType->td_name }}</td>
                                <td class="text-right">
                                    <a href="{{ route('get.put.norm.type', $normType->id_tipo_norma) }}">
                                        <i class="fas fa-edit text-info"></i>
                                    </a>
                                </td>
                                <td class="text-left">
                                    <form action="{{ route('delete.norm.type', $normType->id_tipo_norma) }}" method="POST" class="conf_form">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-link p-0 m-0 text-danger" type="submit"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>          
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info bg-info text-white rounded-0 border-0 shadow-sm">
                    <strong>Ningún resultado encontrado</strong>
                </div>
            @endif
        </div>
    </div>
@stop