@extends('layouts.main')

@section('section-title', 'Normas - editar') 

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <div class="card border-0 rounded-0 shadow shadower">
                <div class="card-body">
                    {!! Form::model($norm, ['route' => ['put.norm', 'id_norma' => $norm->id_norma, 'id_tipo_norma' => $norm->id_tipo_norma], 'method' => 'PUT', 'files' => true, 'data-parsley-validate' => true, 'data-parsley-errors-messages-disabled' => true]) !!}
                        @csrf
                        <div class="row">
                            <div class="col-md-6 pr-1">
                                <div class="form-group">
                                    <label for="id_norma">Número</label>
                                    <input type="text" class="form-control rounded-0" name="id_norma" placeholder="165/19" value="{{ $norm->id_norma }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 pl-1">
                                <div class="form-group">
                                    <label for="id_tipo_norma">Tipo de norma</label>
                                    <select name="id_tipo_norma" class="form-control rounded-0" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach ($normTypes as $normType)
                                            @if($normType->id_tipo_norma == $norm->id_tipo_norma)
                                                <option value="{{ $normType->id_tipo_norma }}" selected>{{ $normType->desc_tipo_norma }} </option>
                                            @else
                                                <option value="{{ $normType->id_tipo_norma }}">{{ $normType->desc_tipo_norma }} </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc_norma">Descripción</label>
                            <textarea rows="5" name="desc_norma" class="form-control rounded-0" required>{{ $norm->desc_norma }}</textarea>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 pr-1">
                                    <label for="fec_norma">Fecha norma</label>
                                    <input type="date" class="form-control rounded-0" name="fec_norma" value="{{ !is_null($norm->fec_norma) ? date('Y-m-d', strtotime($norm->fec_norma)) : '' }}">
                                </div>
                                <div class="col-md-6 pl-1">
                                    <label for="fec_carga">Fecha carga</label>
                                    <input type="date" class="form-control rounded-0" name="fec_carga" value="{{ !is_null($norm->fec_carga) ? date('Y-m-d', strtotime($norm->fec_carga)) : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 pr-1">
                                    <label for="idtema">Tema</label>
                                    <select name="idtema" class="form-control rounded-0">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($temas as $tema)
                                            @if($tema->idtema == $norm->idtema)
                                                <option value="{{ $tema->idtema }}" selected>{{ $tema->tema }}</option>
                                            @else
                                                <option value="{{ $tema->idtema }}">{{ $tema->tema }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 pl-1">
                                    <label for="norm_folder">Carpeta Archivo</label>
                                    <select name="norm_folder" class="form-control rounded-0">
                                        <option value="" {{ is_null($norm->carpeta_texto) ? 'selected' : '' }}>Seleccionar...</option>
                                        <option value="files" {{ $norm->carpeta_texto == 'files' ? 'selected' : '' }}>Files</option>
                                        <option value="files/parte2" {{ $norm->carpeta_texto == 'files/parte2' ? 'selected' : '' }}>Parte 2</option>
                                        <option value="files/parte3" {{ $norm->carpeta_texto == 'files/parte3' ? 'selected' : '' }}>Parte 3</option>
                                        <option value="files/parte4" {{ $norm->carpeta_texto == 'files/parte4' ? 'selected' : '' }}>Parte 4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label for="texto_norma">Archivo</label>
                            <input type="file" name="texto_norma" class="form-control-file">
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
        <div class="col-md-8 offset-md-2">
            <div class="card bg-primary text-white border-0 rounded-pill shadow-sm shadower">
                <div class="card-body pb-3">
                    <h5 class="m-0 d-inline-block">
                        <i class="fas fa-lg fa-file-alt pr-2"></i>
                        <strong>{{ $norm->texto_norma }}</strong>
                    </h5>
                    @if(!is_null($norm->carpeta_texto))
                        <form action="{{ route('delete.norm.archive', $norm->texto_norma) }}" method="POST" class="d-inline-block float-right">
                            {{ method_field('DELETE') }}
                            @csrf
                            <button class="btn btn-link p-0 m-0 text-white" type="submit"><i class="fas fa-lg fa-trash"></i></button>
                        </form>
                    @else
                        <h5 class="text-white float-right m-0">Ruta de archivo no especificada</h5>
                    @endif
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
