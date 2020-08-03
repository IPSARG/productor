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
                    <p class="m-0">Agregar coe a: <strong>{{ $desc_nodo }}</strong></p>
                </div>
                <div class="card-body">
                    <form action="{{ route('post.coe') }}" method="POST" enctype="multipart/form-data" data-parsley-validate data-parsley-errors-messages-disabled>
                        @csrf
                        <input type="hidden" name="cod_padre" value="{{ $cod_hijo }}">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 pr-1">
                                    <label for="id_norma">Número</label>
                                    <input type="text" class="form-control rounded-0" name="id_norma" placeholder="CER18" required>
                                </div>
                                <div class="col-md-6 pl-1">
                                    <label for="idjurisdiccion">Jurisdicción</label>
                                    <select name="idjurisdiccion" class="form-control rounded-0" required>
                                        @foreach ($jurisdictions as $juri)
                                            <option value="{{ $juri->idjurisdiccion }}">{{ $juri->jurisdiccion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="id_tipo_norma">Tipo de norma</label>
                            <select name="id_tipo_norma" class="form-control rounded-0" required>
                                <option value="COEFI" selected>Coeficientes</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="desc_norma">Descripción</label>
                            <textarea rows="5" name="desc_norma" class="form-control rounded-0" required></textarea>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 pr-1">
                                    <label for="fec_norma">Fecha norma</label>
                                    <input type="date" class="form-control rounded-0" name="fec_norma" value="">
                                </div>
                                <div class="col-md-6 pl-1">
                                    <label for="fec_carga">Fecha carga</label>
                                    <input type="date" class="form-control rounded-0" name="fec_carga" value="">
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
                                            <option value="{{ $tema->idtema }}">{{ $tema->tema }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 pl-1">
                                    <label for="norm_folder">Carpeta Archivo</label>
                                    <select name="norm_folder" class="form-control rounded-0" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="files">Files</option>
                                        <option value="files/parte2">Parte 2</option>
                                        <option value="files/parte3">Parte 3</option>
                                        <option value="files/parte4">Parte 4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="texto_norma">Archivo</label>
                            <input type="file" name="texto_norma" class="form-control-file" required>
                        </div>
                        <div class="card-footer border_top rounded-0 bg-white">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-success rounded-pill border-0 px-4 shadow-green-left float-right">Cargar</button>
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