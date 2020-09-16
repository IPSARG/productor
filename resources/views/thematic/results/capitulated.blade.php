@extends('layouts.main')

@section('section-title', 'Índice temático')

@section('content')
    <div class="row">
        <div class="col-md-12 mt-4 mb-2">
            @include('partials._breadcrumbs')
        </div>
    </div>
    <div class="row mb-4">
        {{--  {{ dd($tematics,$firstDescArt,$firstLvl) }}  --}}

             {{--  @foreach ($tematics as $tematic)
               <div class="card border-0 rounded-0 shadow mb-2 card_cap" data-nivel="{{$tematic->nivel}}">
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-10">
                                @isset($firstDescArt)
                                    @if($loop->iteration === 1)
                                        <p class="m-0 font-weight-bold text-trivia d-inline-block">
                                            <i>{{ $firstDescArt->descarticulo }}</i>
                                        </p>
                                    @endif
                                @endif
                                @if($tematic->nivel == $firstLvl)
                                    @php  $count = $count + 1 @endphp
                                    <div class="font-weight-bold text-orange">
                                        <p class="m-0">{{$tematic->descarticulo}}</p>
                                    </div>
                                @endif
                                @if($tematic->nivel > $firstLvl && $tematic->nivel < 9 && $firstLvl !== null)
                                    <p class="m-0 {{ $tematic->nivel == 3 ? 'text-primary pl-2' : 'text-success pl-4' }} font-weight-bold ">{{ $tematic->descarticulo}} </p>
                                @endif
                                @if($tematic->nivel >= 9)
                                    <p class="m-0 font-weight-bold text-dark pl-5">
                                        {{ $tematic->codarticulo !== '' ? 'Art. ' . $tematic->codarticulo : '' }}
                                        {{$tematic->descarticulo}}
                                    </p>
                                @endif
                            </div>


                             <div class="col-md-2 pl-1" data-descTipoNorma="{{ $tematic->desc_tipo_norma }}" data-idTipoNorma="{{$tematic->id_tipo_norma}}" data-idNorma="{{$tematic->id_norma}}" data-articulo="{{ $tematic->codarticulo != '' ? $tematic->codarticulo : '' }}" data-nivel="{{$tematic->nivel}}">
                                <ul class="list-inline float-right mb-0">
                                    <li class="list-inline-item">
                                        <a href=" route('get.link.norm', ['codnorma'=>$tematic->codnorma,'nroorden'=>$tematic->id]) "><i class="fas fa-link text-secondary"></i></a>

                                        <a href=""><i class="fas fa-edit text-info"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <form action="{{ route('delete.trvarticulonorma',['codnorma'=>$tematic->codnorma,'nroorden'=>$tematic->id] )}}" method="POST" class="conf_form">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-link p-0" type="submit">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach  --}}

        <style>

            .col_Defecto{
                width: 40%;
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
            .col_Azul{
                width: 100%;
                background-color:rgb(23, 13, 220);
                min-height: 50px;
                padding: 10px;
                padding-bottom: 50px !important;
            }
            .col_Verde{
                width: 100%;
                background-color:rgb(68, 218, 48);
                min-height: 50px;
                padding: 10px;
                padding-bottom: 50px !important;
            }
            .col_Normal{
                width: 100%;
                background-color:rgb(148, 137, 172);
                min-height: 50px;
                padding: 10px;
                padding-bottom: 50px !important;
            }
            .header-rojo{
                background-color:rgba(255, 153, 153, 0.946) !important;
            }
            .header-azul{
                background-color:rgb(110, 127, 255) !important;
            }
            .header-verde{
                background-color:rgb(110, 255, 122) !important;
            }
            .col_Rojo_children{
                background-color:hsl(0, 33%, 63%);
                padding-bottom: 50px !important;
            }
            .col_Azul_children{
                background-color:rgb(53, 48, 141);
                padding-bottom: 50px !important;
            }
            .col_Verde_children{
                background-color:rgb(48, 141, 56);
                padding-bottom: 50px !important;
            }
            .portlet{
                background-color: #a5a5a5;
                border: black solid 4px;
                margin: 5px;
            }
            .portlet-header{
                font-size: 20px;
            }
            .drop-placeholder {
                background-color: lightgray;
                height: 3.5em;
                padding-top: 12px;
                padding-bottom: 12px;
                line-height: 1.2em;
                }
        </style>

        <div class="col-md-4">

            <div>
                <h5>Alta de Contenedor Rojo (lvl 2)</h5>
                <div class="form-check form-check-inline">
                    <input class="form-control w-60" type="text" id="Rojo-titulo" name="titulo"  placeholder="Titulo...">
                    <a  id="Rojo-alta" class="btn btn-primary w-40 ml-10"  role="button">Crear</a>
                </div>
                <div class="row col_Rojo" id="Rojo-column" style="width: 60% !important">
                </div>
            </div>
            <div>
                <h5>Alta de Contenedor Azul (lvl 3)</h5>
                <div class="form-check form-check-inline">
                    <input class="form-control w-60" type="text" id="Azul-titulo" name="titulo"  placeholder="Titulo...">
                    <a  id="Azul-alta" class="btn btn-primary w-40 ml-10"  role="button">Crear</a>
                </div>
                <div class="row col_Azul" id="Azul-column" style="width: 60% !important">
                </div>
            </div>
            <div>
                <h5>Alta de Contenedor Verde (lvl 4)</h5>
                <div class="form-check form-check-inline">
                    <input class="form-control w-60" type="text" id="Verde-titulo" name="titulo"  placeholder="Titulo...">
                    <a  id="Verde-alta" class="btn btn-primary w-40 ml-10"  role="button">Crear</a>
                </div>
                <div class="row col_Verde" id="Verde-column" style="width: 60% !important">
                </div>
            </div>
            <div>
                <h5>Seleccion de Norma (lvl 9)</h5>
                <div class="form-check form-check-inline">
                    <input class="form-control w-60" type="text" id="Normal-titulo" name="titulo"  placeholder="Titulo...">
                    <a  id="Normal-alta" class="btn btn-primary w-40 ml-10"  role="button">Crear</a>
                </div>
                <div class="row col_Normal" id="Normal-column" style="width: 60% !important">
                </div>
            </div>
            <div>
                <h5>Guardar Cambios</h5>
                <button type="button" id="guardar-todo" class="btn btn-primary">Guardar</button>
            </div>
        </div>
            <div class="col-md-8 " style="margin-top:10px">

                <h4 class="font-weight-bold oswald title_section_black">Vista</h4>
                <div class="col_Defecto flex"  style="width: 100%;" id="columna2">


                    {{--  <div class="portlet">
                        <div class="portlet-header blue darken-3 py-2 my-3 text-center white-text collapseButton" data-toggle="collapse"
                          href="#news">News <i class="fas fa-caret-down  ml-2"></i></div>
                        <div class="portlet-content collapse text-center" id="news">
                            <div class="col_Azul_children"></div>
                        </div>
                      </div>  --}}
                </div>

              </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script>

        var arrays=[".col_Defecto",".col_Normal",".col_Rojo",".col_Verde",".col_Azul",".col_Azul_children",".col_Rojo_children",".col_Verde_children"];
       var card_cont={{ 0 }};

       var pos=0;
       var pos_verde=0;
       var pos_azul=0;
       var last_rojo=0;
       var last_azul=0;
       var last_verde=0;

        function get_hijos(divs){
        var datos = new Array();
        divs.children('.portlet').each(function( ind,valor ) {
                     var texto = '';
                     if($(valor).hasClass('header-rojo')){
                         texto = $(valor).children('div').children('.input-valor')[0].value;
                         var da = {color: '2', codnorma: $(valor).attr('codnorma'), nroorden: $(valor).attr('nroorden'),texto:texto,hijos:get_hijos($(valor).children('.portlet-content').children('.col_Rojo_children'))};
                         datos.push(da)
                     }

                     else if($(valor).hasClass('header-azul')){
                         texto = $(valor).children('div').children('.input-valor')[0].value;
                         var da = {color: '3', codnorma: $(valor).attr('codnorma'), nroorden: $(valor).attr('nroorden'),texto:texto,hijos:get_hijos($(valor).children('.portlet-content').children('.col_Azul_children'))};
                         datos.push(da)
                     }
                     else if($(valor).hasClass('header-verde')){
                         texto = $(valor).children('div').children('.input-valor')[0].value;
                         var da = {color: '4', codnorma: $(valor).attr('codnorma'), nroorden: $(valor).attr('nroorden'),texto:texto,hijos:get_hijos($(valor).children('.portlet-content').children('.col_Verde_children'))};
                         datos.push(da)
                     }
                     else {
                         texto = $(valor).children('div').children('.input-valor')[0].value;
                         var da = {color: '9', codnorma: $(valor).attr('codnorma'), nroorden: $(valor).attr('nroorden'),texto:texto};
                         datos.push(da)
                     }

                 });
                 //console.log($(this))

             return datos;
        }

       $(document).on("click", "#guardar-todo", function() {
        var divs = $(".col_Defecto");
        var datos= new Array();
        datos= get_hijos(divs);
        console.log(datos);
        $.ajax({
            url: "{{ route('post.updatecodoFinales') }}",
            method: 'POST',
            data:{
                datos:datos
            },
            success: function(respuesta){
              console.log(respuesta)
            }
        });
       });





       @if(isset($firstDescArt))
       load_normalDiv("{{ $firstDescArt->descarticulo }}","#columna2","{{ $firstDescArt->codnorma }}","{{ $firstDescArt->id }}");
       @endif




        @foreach ($tematics as $key=> $tematic)

        @if($key >0)
            @if($tematic->nivel == 2)
            pos=load_rojoDiv("{{ $tematic->descarticulo }}","#columna2","{{ $tematic->codnorma }}","{{ $tematic->id }}");
            
            last_rojo=pos;
            last_azul=pos;
            last_verde=pos;
            @endif
            {{--  @if($tematic->nivel > $firstLvl && $tematic->nivel < 9 && $firstLvl !== null)  --}}
                @if($tematic->nivel==3)
                pos_azul= load_azulDiv("{{ $tematic->descarticulo }}","#children_card_"+last_rojo,"{{ $tematic->codnorma }}","{{ $tematic->id }}");
                last_azul=pos_azul;
                last_verde=pos_azul;
                @endif
                @if($tematic->nivel==4)
                last_verde= load_verdeDiv("{{ $tematic->descarticulo }}","#children_card_"+last_azul,"{{ $tematic->codnorma }}","{{ $tematic->id }}");
                @endif

            {{--  @endif  --}}
            @if($tematic->nivel >= 9)
            load_normalDiv("{{$tematic->descarticulo}}","#children_card_"+last_verde,"{{ $tematic->codnorma }}","{{ $tematic->id }}");

            @endif

        @endif

        @endforeach
        function load_rojoDiv(titulo,columna,codnorma='nuevo',nroorden='nuevo'){
            card_cont++;

            var contenido= '';
            contenido+='<div class="portlet header-rojo" codnorma="'+codnorma+'"nroorden="'+nroorden+'" >';
                contenido+='<div class="portlet-header blue darken-3 py-2 my-3 text-center white-text ">';
                contenido+='<input type="text" class="form-control input-valor" value="'+titulo+'"><i class="fas fa-caret-down  ml-2 collapseButton" data-toggle="collapse" href="#card'+card_cont+'"></i></div>';
                contenido+='<div class="portlet-content collapse text-center" id="card'+card_cont+'">';
                contenido+='    <div class="col_Rojo_children" id="children_card_'+card_cont+'"></div>';
                contenido+='</div>';
              contenido+='</div>';

            $(columna).html($(columna).html()+contenido);
            return card_cont;
        }
        function load_azulDiv(titulo,columna,codnorma='nuevo',nroorden='nuevo'){
            card_cont++;
            var contenido= '';
            contenido+='<div class="portlet header-azul" codnorma="'+codnorma+'"nroorden="'+nroorden+'" >';
                contenido+='<div class="portlet-header blue darken-3 py-2 my-3 text-center white-text  " >';
                contenido+='<input type="text" class="form-control input-valor" value="'+titulo+'"> <i class="fas fa-caret-down collapseButton ml-2" data-toggle="collapse"  href="#card'+card_cont+'"></i></div>';
                contenido+='<div class="portlet-content collapse text-center" id="card'+card_cont+'">';
                contenido+='    <div class="col_Azul_children" id="children_card_'+card_cont+'"></div>';
                contenido+='</div>';
              contenido+='</div>';
            $(columna).html($(columna).html()+contenido);
            return card_cont;

        }
        function load_verdeDiv(titulo,columna,codnorma='nuevo',nroorden='nuevo'){
            card_cont++;
            var contenido= '';
            contenido+='<div class="portlet header-verde" codnorma="'+codnorma+'"nroorden="'+nroorden+'" >';
                contenido+='<div class="portlet-header blue darken-3 py-2 my-3 text-center white-text  " >';
                    contenido+='<input type="text" class="form-control input-valor" value="'+titulo+'"> <i class="fas fa-caret-down collapseButton ml-2" data-toggle="collapse"  href="#card'+card_cont+'"></i></div>';
                contenido+='<div class="portlet-content collapse text-center" id="card'+card_cont+'">';
                contenido+='    <div class="col_Verde_children" id="children_card_'+card_cont+'"></div>';
                contenido+='</div>';
              contenido+='</div>';
            $(columna).html($(columna).html()+contenido);
            return card_cont;

        }
        function load_normalDiv(titulo,columna,codnorma='nuevo',nroorden='nuevo'){
            card_cont++;
            var contenido= '';
            contenido='<div class="portlet"  codnorma="'+codnorma+'" nroorden="'+nroorden+'" ><div class="portlet-header" ><input type="text" class="form-control input-valor" value="'+titulo+'"></div></div>';

            $(columna).html($(columna).html()+contenido);
            return card_cont;

        }
         $(document).on("click", "#Rojo-alta", function() {
            var titulo = $("#Rojo-titulo").val();
            load_rojoDiv(titulo,"#Rojo-column","{{ $tematics[0]->codnorma }}");
            loadall()
         });

         $(document).on("click", "#Azul-alta", function() {
            var titulo = $("#Azul-titulo").val();
            load_azulDiv(titulo,"#Azul-column","{{ $tematics[0]->codnorma }}");
            loadall()
         });
         $(document).on("click", "#Verde-alta", function() {

            var titulo = $("#Verde-titulo").val();
            load_verdeDiv(titulo,"#Verde-column","{{ $tematics[0]->codnorma }}");
            loadall()
         });
         $(document).on("click", "#Normal-alta", function() {

            var titulo = $("#Normal-titulo").val();
            //
            var contenido= '';
            load_normalDiv(titulo,"#Normal-column","{{ $tematic->codnorma }}");
            loadall()
         });



         loadall()
        function loadall() {
            $( ".col_Defecto" ).sortable({
            connectWith: arrays,
            handle: ".portlet-header",
            cancel: ".portlet-toggle",
            placeholder: "drop-placeholder"
            });
            $( ".col_Normal" ).sortable({
                connectWith: arrays,
                handle: ".portlet-header",
                cancel: ".portlet-toggle",
                placeholder: "drop-placeholder"
                });
            $( ".col_Rojo" ).sortable({
                connectWith: arrays,
                handle: ".portlet-header",
                cancel: ".portlet-toggle",
                placeholder: "drop-placeholder"
            });
            $( ".col_Verde" ).sortable({
                connectWith: arrays,
                handle: ".portlet-header",
                cancel: ".portlet-toggle",
                placeholder: "drop-placeholder"
            });
            $( ".col_Azul" ).sortable({
                connectWith: arrays,
                handle: ".portlet-header",
                cancel: ".portlet-toggle",
                placeholder: "drop-placeholder"
            });
            $( ".col_Rojo_children" ).sortable({
                connectWith: arrays,
                handle: ".portlet-header",
                cancel: ".portlet-toggle",
                placeholder: "drop-placeholder"
                });
            $( ".col_Azul_children" ).sortable({
                connectWith: arrays,
                handle: ".portlet-header",
                cancel: ".portlet-toggle",
                placeholder: "drop-placeholder"
                });
            $( ".col_Verde_children" ).sortable({
                connectWith: arrays,
                handle: ".portlet-header",
                cancel: ".portlet-toggle",
                placeholder: "drop-placeholder"
                });
        };

    </script>

@stop
