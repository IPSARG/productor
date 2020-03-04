@extends('layouts.main')

@section('section-title', 'Normas - resultado de búsqueda') 

@section('content')
    <div class="row mt-3 mb-4">
        <div class="col-md-12">
            @if(count($norms) > 0)
                <h5 class="pb-2">Se econtraron <strong class="text-secondary">{{ count($norms) }}</strong> resultados</h5>
                <table class="table table-striped mb-0 shadow">
                    <thead class="border-0 bg-trivia text-white">
                        <tr>
                            <th class="border-0">Número</th>
                            <th class="border-0">Tipo</th>
                            <th class="border-0">Descripción</th>
                            <th class="border-0">Texto</th>
                            <th class="border-0">Jurisdicción</th>
                            <th class="border-0">F. Norma</th>
                            <th class="border-0">F. Carga</th>
                            <th colspan="2" class="border-0">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($norms as $norm)
                            <tr>
                                <td class="text-orange font-weight-bold">{{ $norm->id_norma }}</td>
                                <td class="text-orange font-weight-bold" width="20%" >{{ $norm->nt_desc }}</td>
                                <td width="40%" class="font-weight-bold">{{ str_limit($norm->desc_norma, 120, '...') }}</td>
                                <td>
                                    <a href="{{ $norm->texto_norma }}" target="_blank">
                                        <span class="badge bg-secondary text-white pt-1 shadow-sm">{{ $norm->texto_norma }}</span>
                                    </a>   
                                </td>
                                <td>{{ $norm->j_acr }}</td>
                                <td width="12%">{{ !is_null($norm->fec_norma) ? date('d-m-y', strtotime($norm->fec_norma)) : '-' }} </td>
                                <td width="12%">{{ !is_null($norm->fec_carga) ? date('d-m-y', strtotime($norm->fec_carga)) : '-' }}</td>
                                <td class="text-right">
                                    <a href="{{ route('get.put.norm', ['id_norma' => $norm->id_norma, 'id_tipo_norma' => $norm->id_tipo_norma] ) }}">
                                        <i class="fas fa-edit text-info"></i>
                                    </a>
                                </td>
                                <td class="text-left">
                                    <form action="{{ route('delete.norm', ['id_norma' => $norm->id_norma, 'id_tipo_norma' => $norm->id_tipo_norma]) }}" method="POST" class="conf_form">
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
    <div class="d-flex flex-row justify-content-center align-items-center">
        {{ $norms->appends(Request::except('page'))->links() }}
    </div>
@stop