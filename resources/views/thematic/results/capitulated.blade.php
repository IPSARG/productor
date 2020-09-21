@extends('layouts.main')

@section('section-title', 'Índice temático')

@section('content')
    <div class="row">
        <div class="col-md-12 mt-4 mb-2">
            @include('partials._breadcrumbs')
        </div>
    </div>
    <style>
    .bg-dark2{
        background-color: rgb(121, 120, 120);
    }
    </style>
    <style>

        .col_Defecto{
            width: 100%;
            background-color:#90e3e9;
            min-height: 100px;
            padding: 10px;
            margin: 10px;
            padding-bottom: 50px !important;

        }
        .col_Rojo{
            width: 100%;
            background-color:hsl(0, 100%, 44%);
            min-height: 50px;
            padding: 10px;
            padding-bottom: 50px !important;
        }

        .portlet{
            background-color: #e6e6e6;
            border: black solid 4px;
            margin: 5px;
        }

        .drop-placeholder {
            background-color: lightgray;
            height: 3.5em;
            padding-top: 12px;
            padding-bottom: 12px;
            line-height: 1.2em;
            }

    .fijo {
        position: fixed;
        min-height: 120px;
        right: 15px;
        text-align: center;
        word-wrap: break-word;
        background-color: aquamarine;
    }
    </style>
    <div class="row">
    <div class="col-4 fijo">

            <h5>Alta de Contenedor</h5>

            <div class="input-group">
                <input class="form-control " type="text" id="Rojo-titulo" name="titulo"  placeholder="Titulo...">
                <div class="input-group-append">
                    {{--  <span class="input-group-text" id="my-addon">Text</span>  --}}
                    <input class="input-group-text" type="text" name="" placeholder="Numero de Articulo" id="art_alta">
                </div>
            </div>
            <div class="form-group">
            </div>
            <small id="helpId" class="form-text text-muted"> El numero de articulo solo se usara en caso de que sea nivel 9</small>

            <div class="form-group">
                <label for="">Nivel</label>
                    <select  class="form-control"  id="valor_alta">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="9">9</option>
                    </select>
                <small id="helpId" class="form-text text-muted">1:solo el primer nodo 2: color Naranja, 3:color azul, 4:color verde, 9:color negro</small>
              </div>
                <a  id="Rojo-alta" class="btn btn-primary w-100 " style=""  role="button">Crear</a>
            <div class="row col_Rojo" id="Rojo-column" style="width: 100% !important">
            </div>

        <div>
            <button type="button" id="guardar-todo" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </div>
    <div class="col-6 mb-4">
        <div class="col-12 col_Defecto">
            @foreach ($tematics as $key => $tematic)
            {{--  {{ dd($firstLvl,$firstDescArt) }}  --}}
                <div class="portlet card border-0 rounded-0 shadow mb-2 " data-nivel="{{$tematic->nivel}}">
                    <div class="card-body py-2 portlet-header form-check-inline" >
                                @isset($firstDescArt)
                                    @if($loop->iteration === 1)
                                <div class="divcontenedor font-weight-bold w-100" id="div_{{ $firstDescArt->id }}">
                                    <label   class="m-0 font-weight-bold text-dark pl-5" style="float:left;margin-right: 5px !important;padding-left: 0px !important;"></label>

                                    <p class="m-0 font-weight-bold text-trivia d-inline-block">
                                        {{ $firstDescArt->descarticulo }}
                                    </p>
                                    <button type="button" class="btn btn-primary float-right editarbutton" @if($key==0) bloqueado="true" @endif dataid="{{$firstDescArt->id}}" texto="{{ $firstDescArt->descarticulo }}" nivel="{{ $firstDescArt->nivel }}" >Editar</button>
                                </div>

                                    @endif
                                @endif
                                @if($tematic->nivel == 2)
                                    @php  $count = $count + 1 @endphp
                                    <div class="divcontenedor font-weight-bold text-orange w-100" id="div_{{ $tematic->id }}">
                                        <label   class="m-0 font-weight-bold text-dark pl-5" style="float:left;margin-right: 5px !important;padding-left: 0px !important;"></label>

                                        <p class="m-0">{{$tematic->descarticulo}}</p>
                                        <button type="button" class="btn btn-primary float-right editarbutton" @if($key==0) bloqueado="true" @endif dataid="{{$tematic->id}}" texto="{{ $tematic->descarticulo }}" nivel="{{ $tematic->nivel }}" >Editar</button>
                                    </div>
                                @endif


                                @if($tematic->nivel ==3)
                                <div class="divcontenedor font-weight-bold w-100" id="div_{{ $tematic->id }}">
                                    <label   class="m-0 font-weight-bold text-dark pl-5" style="float:left;margin-right: 5px !important;padding-left: 0px !important;"></label>

                                    <p class="m-0 text-primary pl-2 font-weight-bold ">{{ $tematic->descarticulo}} </p>
                                    <button type="button" class="btn btn-primary float-right editarbutton" dataid="{{$tematic->id}}" texto="{{ $tematic->descarticulo }}" nivel="{{ $tematic->nivel }}" >Editar</button>
                                </div>
                                @endif
                                @if($tematic->nivel ==4)
                                <div class="divcontenedor font-weight-bold w-100" id="div_{{ $tematic->id }}">
                                    <label   class="m-0 font-weight-bold text-dark pl-5" style="float:left;margin-right: 5px !important;padding-left: 0px !important;"></label>

                                    <p class="m-0 text-success pl-4 font-weight-bold ">{{ $tematic->descarticulo}} </p>
                                    <button type="button" class="btn btn-primary float-right editarbutton" dataid="{{$tematic->id}}" texto="{{ $tematic->descarticulo }}" nivel="{{ $tematic->nivel }}" >Editar</button>
                                </div>
                                @endif
                                @if($tematic->nivel >= 9)


                                <div class="divcontenedor font-weight-bold w-100" id="div_{{ $tematic->id }}">
                                    <label   class="m-0 font-weight-bold text-dark pl-5" style="float:left;margin-right: 5px !important;padding-left: 0px !important;">  {{ $tematic->codarticulo !== '' ? 'Art. ' . $tematic->codarticulo.' ' : '' }}</label>
                                    <p class="m-0 font-weight-bold text-dark pl-5" style="margin-left:4px !important">

                                        {{$tematic->descarticulo}}
                                    </p>
                                    <button type="button" class="btn btn-primary float-right editarbutton" codarticulo="{{ $tematic->codarticulo }}" textaux="{{ $tematic->codarticulo !== '' ? 'Art. ' . $tematic->codarticulo : '' }}" dataid="{{$tematic->id}}" texto="{{ $tematic->descarticulo }}" nivel="{{ $tematic->nivel }}" >Editar</button>
                                </div>

                                @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modelId">
  Launch
</button>

<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                  <label for="">Titulo</label>
                  <input class="form-control" type="text" id="dataid_modal" hidden>
                  <input class="form-control" type="text" id="titulo_modal">
                  <small id="helpId" class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    <label for="">Nivel</label>
                        <select  class="form-control"  id="valor_modal">
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="9">9</option>
                        </select>
                    <small id="helpId" class="form-text text-muted">1:solo el primer nodo 2: color Naranja, 3:color azul, 4:color verde, 9:color negro</small>
                  </div>
                {{--  <input class="form-control" type="text" id="valor_modal">  --}}
                <div class="form-group" id="codarticulomodal" hidden>
                    <label for="">Cod Articulo</label>
                    <input class="form-control" type="text" id="codarticulo_modal">
                    <small id="helpId" class="form-text text-muted"></small>
                  </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="savemodal" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script>
       $(document).on("click", ".editarbutton", function() {
        var dataid=$(this).attr('dataid');
        var texto=$(this).attr('texto');
        var nivel=$(this).attr('nivel');
        $("#titulo_modal").val(texto);
        $("#valor_modal").val(nivel).change();
        $("#dataid_modal").val(dataid);
        if(nivel ==9){
            var codarticulo= $(this).attr('codarticulo')
            $("#codarticulomodal").removeAttr('hidden')
            $("#codarticulo_modal").val(codarticulo)
        }
        else {
            $("#codarticulomodal").attr('hidden','hidden')
            $("#codarticulo_modal").val('')
        }
        $('#modelId').modal('show');
       });
       $(document).on("change", "#valor_modal", function() {

        if($(this).val()==9){
            $("#codarticulomodal").removeAttr('hidden')
        }

       });


       $(document).on("click", "#savemodal", function() {

            var texto =$("#titulo_modal").val()
         var nuevo = false;
            var nivel =$("#valor_modal").val()
            var codarticulo =$("#codarticulo_modal").val()
            var iddiv= $("#div_"+$("#dataid_modal").val());
            console.log(iddiv.length)
            if(iddiv.length==0){
                iddiv= $("#nuevo_"+$("#dataid_modal").val());
                nuevo = true;
            }
            var p = iddiv.children('p')
            var label =iddiv.children('label')
            p.html(texto)
            if(nivel=="2"){
                p.attr('class', 'text-orange')
            }
            else if(nivel=="3"){
                p.attr('class', 'text-primary')
            }
            else if(nivel!=9 && nivel >2){
                p.attr('class', 'text-success')
            }
            if(nivel!=9){
                label.html('')
            }
            if(codarticulo!='' && nivel==9 ){

                label.html('Art. '+codarticulo)
                iddiv.children('button').attr({'texto':texto,'nivel':nivel,'codarticulo':codarticulo,'nuevo':nuevo})
            }

            iddiv.children('button').attr({'texto':texto,'nivel':nivel,'nuevo':nuevo})
       });

var nuevocont=0;
$(document).on("click", "#Rojo-alta", function() {
    var titulo =$("#Rojo-titulo").val()
    var valor =$("#valor_alta").val()
    var art =$("#art_alta").val()
    var classe ='';
    if(titulo !=''){
        if(valor=="2"){
            classe= 'text-orange';
        }
        else if(valor=="3"){
            classe= 'text-primary';
        }
        else if(valor!=9){
            classe= 'text-success';
        }
        var contenido ='';
        contenido+='<div class="portlet card border-0 rounded-0 shadow mb-2 " data-nivel="9">';
            contenido+='<div class="card-body py-2 portlet-header form-check-inline">';
               contenido+=' <div class="divcontenedor font-weight-bold w-100" id="nuevo_'+nuevocont+'">';

                    contenido+='<label class="m-0 font-weight-bold text-dark " style="float:left;margin-right: 5px !important;padding-left: 0px !important;">';
                       if(valor==9)
                        contenido+='Art. '+art;
                        contenido+='</label>';
                    contenido+='<p class="m-0 font-weight-bold text-dark  '+classe+'" style="margin-left:4px !important">'+titulo+'</p>';
                    contenido+='<button type="button" class="btn btn-primary float-right editarbutton" codarticulo="'+art+'" textaux="Art. '+art+'" dataid="'+nuevocont+'" nuevo="true" texto="'+titulo+'" nivel="'+valor+'">Editar</button>';
                contenido+='</div>';
            contenido+='</div>';
        contenido+='</div>';
        nuevocont++;
        $("#Rojo-column").html($("#Rojo-column").html()+contenido)
    }
});

        $(document).on("click", "#guardar-todo", function() {

            var datos = new Array();
            $(".col_Defecto ").children('.portlet').children('.card-body').children(".divcontenedor").children(".editarbutton").each(function( ind,valor ) {

            var dataid=$(valor).attr('dataid');
            var texto=$(valor).attr('texto');
            var nivel=$(valor).attr('nivel');
            var nuevo=$(valor).attr('nuevo');
            if(nuevo==undefined){
                nuevo=false;
            }
            var codarticulo =$(valor).attr('codarticulo')

            var da = {id:dataid,texto:texto,nivel:nivel,codarticulo:codarticulo,nuevo:nuevo,codnorma:'{{ $tematics[0]->codnorma }}' };
            datos.push(da)

            });
            console.log(datos)
            $.ajax({
                url: "{{ route('post.updatecodoFinales') }}",
                method: 'POST',
                data:{
                    datos:JSON.stringify(datos)
                },
                success: function(respuesta){
                  console.log(respuesta)
                  if(respuesta=="true"){
                      alert('Se han guardado los cambios. la pagina se volvera a cargar');
                      location.reload();
                  }
                  else{
                      alert('Ha ocurrido un error,vuelva a intentarlo mas tarde. ');
                  }
                }
            });
        });






       $( ".col_Defecto" ).sortable({
        connectWith: ['.col_Rojo'],
        handle: ".portlet-header",
        cancel: ".portlet-toggle",
        placeholder: "drop-placeholder"
        });
        $( ".col_Rojo" ).sortable({
            connectWith: ['.col_Defecto'],
            handle: ".portlet-header",
            cancel: ".portlet-toggle",
            placeholder: "drop-placeholder"
            });
    </script>

@stop
