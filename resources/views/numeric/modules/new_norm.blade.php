<div class="card border-0 rounded-0 shadow-sm shadower">
    <div class="card-header border-0 rounded-0 bg-trivia">
        <h4 class="header-title m-0 text-white d-inline-block pt-1">Ingresar norma</h4>
        <button class="btn btn-secondary text-white rounded-circle float-right shadow" type="button" data-toggle="modal" data-target="#search_norm"><i class="fas fa-search"></i></button>
    </div>
    <div class="card-body">
        <form action="{{ route('post.norm') }}" method="POST" enctype="multipart/form-data" data-parsley-validate data-parsley-errors-messages-disabled>
            @csrf
            <div class="row">
                <div class="col-md-6 pr-1">
                    <div class="form-group">
                        <label for="id_norma">Número</label>
                        <input type="text" class="form-control rounded-0" name="id_norma" placeholder="165/19" required>
                    </div>
                </div>
                <div class="col-md-6 pl-1">
                    <div class="form-group">
                        <label for="id_tipo_norma">Tipo de norma</label>
                        <select name="id_tipo_norma" class="form-control rounded-0" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($normTypes as $normType)
                                <option value="{{ $normType->id_tipo_norma }}">{{ $normType->desc_tipo_norma }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="desc_norma">Descripción</label>
                <textarea rows="5" name="desc_norma" class="form-control rounded-0" required></textarea>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 pr-1">
                        <label for="fec_norma">Fecha norma</label>
                        <input type="date" class="form-control rounded-0" name="fec_norma">
                    </div>
                    <div class="col-md-6 pl-1">
                        <label for="fec_carga">Fecha carga</label>
                        <input type="date" class="form-control rounded-0" name="fec_carga">
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
                            <option value="files/parte4" selected>Parte 4</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0">
                <label for="texto_norma">Archivo</label>
                <input type="file" name="texto_norma" class="form-control-file" required>
            </div>
        </div>
        <div class="card-footer border_top rounded-0 bg-white">
            <button type="submit" class="btn btn-success rounded-pill border-0 px-4 shadow-green-left">Cargar</button>
        </div>
    </form>
</div>
