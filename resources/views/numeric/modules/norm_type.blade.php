<div class="card border-0 rounded-0 shadow-sm shadower">
    <div class="card-header border-0 rounded-0 bg-orange">
        <h4 class="header-title m-0 text-white d-inline-block pt-1">Ingresar Tipo de norma</h4>
        <button class="btn btn-secondary text-white rounded-circle float-right shadow" type="button" data-toggle="modal" data-target="#search_norm_type"><i class="fas fa-search"></i></button>
    </div>
    <div class="card-body">
        <form action="{{ route('post.norm.type') }}" method="POST" data-parsley-validate data-parsley-errors-messages-disabled novalidate>
            @csrf
            <div class="row">
                <div class="col-md-6 pr-1">
                    <div class="form-group">
                        <label for="desc_tipo_norma">Descripción</label>
                        <input type="text" class="form-control rounded-0" name="desc_tipo_norma" placeholder="AA CJ (Catamarca)" required>
                    </div>
                </div>
                <div class="col-md-6 pl-1">
                    <div class="form-group">
                        <label for="id_tipo_norma">Abreviatura</label>
                        <input type="text" class="form-control rounded-0" name="id_tipo_norma" placeholder="AACJCATA" required>
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
                                <option value="{{ $juri->idjurisdiccion }}">{{ $juri->jurisdiccion }}</option>
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
                                <option value="{{ $doc->idtipodocumento }}">{{ $doc->tipodocumento }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer border_top rounded-0 bg-white">
            <button type="submit" class="btn btn-success rounded-pill border-0 px-4 shadow-green-left">Cargar</button>
        </div>
    </form>
</div>  