<div class="modal fade" id="editNode_{{ IsCoefi::isCoefi(request(), $tematic->desc_nodo) ? $tematic->cod_hijo : $tematic->cod_nodo }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content rounded-0 border-0 shadow-lg">
                <div class="modal-body rounded-0 border-0">
                    <form action="{{ route('put.node', ['cod_nodo' => IsCoefi::isCoefi(request(), $tematic->desc_nodo) ? $tematic->cod_hijo : $tematic->cod_nodo]) }}" method="POST">
                       {{ method_field('PUT')}}
                        @csrf
                        <input type="hidden" name="cod_padre" value="{{ IsCoefi::isCoefi(request(), $tematic->desc_nodo) ? $tematic->cod_hijo : $tematic->cod_nodo }}">
                        <input type="hidden" name="desc_nodo_old" value="{{ $tematic->desc_nodo }}">
                        <div class="input-group">
                            <input type="text" class="form-control rounded-0 form-control-lg" placeholder="Ej Bienes Personales"  aria-describedby="button-addon2" name="desc_nodo" value="{{ $tematic->desc_nodo }}">
                            <div class="input-group-append">
                                <button class="btn btn-info btn-lg text-white rounded-0" type="submit" id="button-addon2">Modificar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
