@extends('layouts.main')

@section('section-title', 'Índice temático')

@section('content')
    <div class="row">
        <div class="col-md-12 mt-4 mb-2">
            @include('partials._breadcrumbs')
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-10 offset-md-1">
            @foreach ($tematics as $tematic)
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
                                        {{--  <a href="{{ route('get.link.norm', ['codnorma'=>$tematic->codnorma,'nroorden'=>$tematic->nroorden]) }}"><i class="fas fa-link text-secondary"></i></a>  --}}

                                        <a href=""><i class="fas fa-edit text-info"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <form action="{{ route('delete.trvarticulonorma',['codnorma'=>$tematic->codnorma,'nroorden'=>$tematic->nroorden] )}}" method="POST" class="conf_form">
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
            @endforeach
        </div>
    </div>
@stop
