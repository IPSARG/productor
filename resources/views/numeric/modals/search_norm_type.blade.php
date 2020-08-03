<div class="modal fade" id="search_norm_type" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content rounded-0 border-0">
                <div class="modal-body px-4">
                    <form action="{{ route('search.norm.type') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 pr-1">
                                <div class="form-group">
                                    <label for="desc_tipo_norma">Descripción</label>
                                    <input type="text" class="form-control rounded-0" name="desc_tipo_norma" placeholder="AA CJ (Catamarca)">
                                </div>
                            </div>
                            <div class="col-md-6 pl-1">
                                <div class="form-group">
                                    <label for="id_tipo_norma">Abreviatura</label>
                                    <input type="text" class="form-control rounded-0" name="id_tipo_norma" placeholder="AACJCATA">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 pr-1">
                                <div class="form-group">
                                    <label for="idjurisdiccion">Jurisdicción</label>
                                    <select name="idjurisdiccion" class="form-control rounded-0">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($jurisdictions as $juri)
                                            <option value="{{ $juri->idjurisdiccion }}">{{ $juri->jurisdiccion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 pl-1">
                                <div class="form-group">
                                    <label for="idtipodocumento">Tipo de documento</label>
                                    <select name="idtipodocumento" class="form-control rounded-0">
                                        <option value="">Seleccionar...</option>
                                        @foreach ($tipodocs as $doc)
                                            <option value="{{ $doc->idtipodocumento }}">{{ $doc->tipodocumento }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-dark rounded-pill text-light border-0 shadow-sm float-right">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    