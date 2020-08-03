<div class="modal fade" id="search_norm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content rounded-0 border-0">
            <div class="modal-body px-4">
                <form action="{{ route('search.norms') }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 pr-1">
                            <div class="form-group">
                                <label for="id_norma">Número</label>
                                <input type="text" class="form-control rounded-0" name="id_norma" placeholder="165/19">
                            </div>
                        </div>
                        <div class="col-md-4 px-1">
                            <div class="form-group">
                                <label for="id_tipo_norma">Tipo de norma</label>
                                <select name="id_tipo_norma" class="form-control rounded-0">
                                    <option value="">Seleccionar...</option>
                                    @foreach ($normTypes as $normType)
                                        <option value="{{ $normType->id_tipo_norma }}">
                                        {{ $normType->desc_tipo_norma }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 pl-1">
                            <div class="form-group">
                                <label for="texto_norma">Texto norma</label>
                                <input type="text" class="form-control rounded-0" name="texto_norma" placeholder="rdgrsalta3118.html">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 pr-1">
                                <label for="fec_norma">Fecha norma</label>
                                <input type="date" class="form-control rounded-0" name="fec_norma" placeholder="First name">
                            </div>
                            <div class="col-md-6 pl-1">
                                <label for="fec_carga">Fecha carga</label>
                                <input type="date" class="form-control rounded-0" name="fec_carga" placeholder="Last name">
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
