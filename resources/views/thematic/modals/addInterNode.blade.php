<div class="modal fade" id="interNode_{{ IsCoefi::isCoefi(request(), $tematic->desc_nodo) ? $tematic->cod_hijo : $tematic->cod_nodo }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content rounded-0 border-0 shadow-lg">
                <div class="modal-header bg-dark text-light rounded-0 border-0">
                    <p class="m-0">Agregar nodo a: <strong>{{ $tematic->desc_nodo }}</strong></p>
                </div>
                <div class="modal-body rounded-0 border-0">
                    <form action="{{ route('post.node') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cod_padre" value="{{ IsCoefi::isCoefi(request(), $tematic->desc_nodo) ? $tematic->cod_hijo : $tematic->cod_nodo }}">
                        <input type="hidden" name="isTabCuad" value="{{ IsCoefi::isCoefi(request(), $tematic->desc_nodo) ? true : false }}">
                        <div class="input-group">
                            <input type="text" class="form-control rounded-0 form-control-lg" placeholder="Ej Bienes Personales"  aria-describedby="button-addon2" name="desc_nodo">
                            <div class="input-group-append">
                                <button class="btn btn-success btn-lg rounded-0" type="submit" id="button-addon2">Agregar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>