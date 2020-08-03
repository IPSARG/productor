@extends('layouts.main')
@section('section-title', 'Aplicativos')
@push('scriptsHead')
@endpush
@section('content')
<div class="row my-4">
   <div class="col-md-7">
      <div class="row">
         <div class="col-12">

         </div>
      </div>
   </div>
   <div class="col-md-5">

   </div>
   <div class="col-12 mt-4">
      <div class="card border-0 rounded-0 shadow-sm shadower">
         <form action="{{ route('aplicativos.update') }}" method="POST" data-parsley-validate="" data-parsley-errors-messages-disabled="" novalidate="">
            @csrf
            <div class="card-header border-0 rounded-0 bg-orange">
               <h4 class="header-title m-0 text-white d-inline-block pt-1">Modificar Aplicativo</h4>
            </div>
            <div class="card-body">
               <div class="col-md-12 ">
                  <div class="form-group">
                     <label for="titulo">Titulo</label>
                     <input type="text" class="form-control rounded-0" name="titulo" value="{{ $aplicativo->titulo }}" required>
                     <input type="text" class="form-control rounded-0" name="id" value="{{ $aplicativo->id }}" hidden>
                  </div>
               </div>
               <div class="col-md-12 ">
                  <div class="form-group">
                     <label for="titulo">Categoria</label>
                     <select id="my-select" class="form-control" name="categoria_id" required>
                        <option value="" disabled selected >Seleccione una opcion</option>
                        @foreach ($categorias as $cate)
                        <option value="{{ $cate->id }}"  @if($cate->id == $aplicativo->categoria_id) selected @endif  >{{ $cate->titulo }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-md-12 ">
                  <div class="form-group">
                     <label for="descripcion">Descripción</label>
                     <textarea rows="3" name="descripcion"  class="form-control rounded-0" >{{ $aplicativo->descripcion }}</textarea>
                  </div>
               </div>
               <div class="col-md-12 ">
                  <div class="form-group">
                     <label for="novedades">Novedades</label>
                     <textarea rows="3" name="novedades" class="form-control rounded-0"  >{{ $aplicativo->novedades }}</textarea>
                  </div>
               </div>
               <div class="col-md-12 ">
                  <div class="form-group">
                     <label for="nota">Nota</label>
                     <textarea rows="3" name="nota" class="form-control rounded-0"  >{{ $aplicativo->nota }}</textarea>
                  </div>
               </div>
               <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i>Agregar fila</button>
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <th  width='20%'>Titulo</th>
                        <th width='10%'>Version</th>
                        <th width='20%'>Link</th>
                        <th width='20%'>Posicion</th>
                        <th width='10%'>Acciones</th>
                     </tr>
                  </thead>
                  <tbody class="agregados">
                    @foreach ($aplicativo->opciones as $opcion)

                    <tr dataid="contador">
                        <td>{{ $opcion->titulo }}</td>
                        <td>{{ $opcion->version }}</td>
                        <td>{{ $opcion->link }}</td>
                        <td><select id="posicion" name="posicion"  class="form-control" name="" disabled>
                            <option value="derecha" @if($opcion->posicion == 'derecha') selected @endif>Derecha</option>
                            <option value="abajo" @if($opcion->posicion == 'abajo') selected @endif>Abajo</option></select></td>
                        <td>
                            <a class="add" title="Agregar" data-toggle="tooltip" style="display: none;"><i class="fas fa-plus-circle"></i></a><a class="edit" title="Editar" data-toggle="tooltip" ><i class="fas fa-edit text-info"></i></a><a class="delete" title="Borrar" data-toggle="tooltip"><i class="fas fa-trash-alt text-danger"></i></a>
                        </td>
                    </tr>
                    @endforeach

                  </tbody>
               </table>
            </div>
            <input class="form-control" type="text" id="opciones" name="opciones"  hidden>

            <div class="card-footer border_top rounded-0 bg-white">
               <button type="submit" class="btn btn-success rounded-pill border-0 px-4 shadow-green-left">Cargar</button>
            </div>
         </form>
      </div>
   </div>
</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
    body {
        color: #404E67;
        background: #F5F7FA;
		font-family: 'Open Sans', sans-serif;
	}
	.table-wrapper {
		width: 700px;
		margin: 30px auto;
        background: #fff;
        padding: 20px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {
        padding-bottom: 10px;
        margin: 0 0 10px;
    }
    .table-title h2 {
        margin: 6px 0 0;
        font-size: 22px;
    }
    .table-title .add-new {
        float: right;
		height: 30px;
		font-weight: bold;
		font-size: 12px;
		text-shadow: none;
		min-width: 100px;
		border-radius: 50px;
		line-height: 13px;
    }
	.table-title .add-new i {
		margin-right: 4px;
	}
    table.table {
        table-layout: fixed;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }
    table.table th:last-child {
        width: 100px;
    }
    table.table td a {
		cursor: pointer;
        display: inline-block;
        margin: 0 5px;
		min-width: 24px;
    }
	table.table td a.add {
        color: #27C46B;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #E34724;
    }
    table.table td i {
        font-size: 19px;
    }
	table.table td a.add i {
        font-size: 24px;
    	margin-right: -1px;
        position: relative;
        top: 3px;
    }
    table.table .form-control {
        height: 32px;
        line-height: 32px;
        box-shadow: none;
        border-radius: 2px;
    }
	table.table .form-control.error {
		border-color: #f50000;
	}
	table.table td .add {
		//display: none;
	}
</style>
<script>
    $(document).ready(function(){
        var contador={{ count($aplicativo->opciones) }};
        var registros = new Array();



        @foreach ($aplicativo->opciones as $key=> $opcion)

        var registro = {
            titulo:'{!! $opcion->titulo !!}',
            version:'{!! $opcion->version !!}',
            link:'{!! $opcion->link !!}',
            posicion: '{!! $opcion->posicion !!}',
        }
        registros[{{ $key }}]=(registro);
        @endforeach
        $("#opciones").val(JSON.stringify(registros))







        $('[data-toggle="tooltip"]').tooltip();
        var actions = '<a class="add" title="Agregar" data-toggle="tooltip"><i class="fas fa-plus-circle"></i></a><a class="edit" title="Editar" data-toggle="tooltip" style="display: none;"><i class="fas fa-edit text-info"></i></a><a class="delete" title="Borrar" data-toggle="tooltip"><i class="fas fa-trash-alt text-danger"></i></a>';
        // Append table with add row form on add new button click
        $(".add-new").click(function(){
            //$(this).attr("disabled", "disabled");
            var index = $("table tbody tr:last-child").index();
            console.log(index)
            contador++;
            var row = '<tr dataid="'+contador+'">' +
                '<td><input type="text" class="form-control" name="titulo" id="name"></td>' +
                '<td><input type="text" class="form-control" name="version" id="department"></td>' +
                '<td><input type="text" class="form-control" name="link" id="phone"></td>' +
                '<td><select id="posicion" name="posicion"  class="form-control" name=""><option value="derecha">Derecha</option><option value="abajo">Abajo</option></select></td>' +
                '<td>' + actions + '</td>' +
            '</tr>';
            $("table").append(row);
            if(contador==0){

                $("table tbody tr").eq(index+1).find(".add, .edit").toggle();
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        // Add row on add button click
        $(document).on("click", ".add", function(){
            var empty = false;
            var input = $(this).parents("tr").find('input[type="text"]');
            var registro = new Array();
            var titulo='';
            var version='';
            var link='';
            var pos =0;
            input.each(function(){
                if(!$(this).val()){
                    $(this).addClass("error");

                    empty = true;
                } else{
                    $(this).removeClass("error");
                }
                switch(pos){
                    case 0: titulo=$(this).val(); break;
                    case 1: version=$(this).val(); break;
                    case 2: link=$(this).val(); break;
                }
                pos++;
            });
            registro = {
                titulo:titulo,
                version:version,
                link:link,
                posicion: $(this).parents("tr").find('select[name="posicion"]').val(),
            }

            $(this).parents("tr").find(".error").first().focus();
            if(!empty){
                input.each(function(){
                    $(this).parent("td").html($(this).val());
                });
                $(this).parents("tr").find('select[name="posicion"]').attr('disabled','disabled')
                registros[contador-1]=(registro);
                console.log(registros)
                $("#opciones").val(JSON.stringify(registros))

                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").removeAttr("disabled");
            }
        });
        // Edit row on edit button click
        $(document).on("click", ".edit", function(){
            var cont =0;
            $(this).parents("tr").find("td:not(:last-child)").each(function(){
                if( cont==3){
                    $(this).find('select[name="posicion"]').removeAttr('disabled')
                }
                else
                $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
                cont++;
            });
            $(this).parents("tr").find(".add, .edit").toggle();
            $(".add-new").attr("disabled", "disabled");
        });
        // Delete row on delete button click
        $(document).on("click", ".delete", function(){
            console.log($(this).parents("tr").attr('dataid'))
            $(this).parents("tr").remove();
            registros.splice($(this).attr('dataid'),1);
            $(".add-new").removeAttr("disabled");
        });
    });
</script>
@stop
