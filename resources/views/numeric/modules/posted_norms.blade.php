@if (count($norms) > 0)
    @foreach ($norms as $date => $norm)
        <div class="card border-0 rounded-0 bg-transparent shadow-sm shadower" id="posted_norms">
            @if(!empty($date) && $date != '')
                <div class="card-header border-0 rounded-0 bg-danger">
                    <h5 class="header-title m-0 text-white">Ingresadas - <small><i>{{ Carbon\Carbon::parse($date)->format('d-m-y') }}</i></small> 
                        {{-- <span class="badge badge-pill badge-secondary float-right text-white">{{ count($norms) }}</span> --}}
                    </h5>
                </div>
            @elseif($date == '' || empty($date))
                <div class="card-header border-0 rounded-0 bg-danger">
                    <h5 class="header-title m-0 text-white">Ingresadas - <small><i>Sin fecha de carga</i></small> 
                    </h5>
                </div>
            @endif
            <ul class="list-group list-group-flush">
                @foreach ($norm as $n)
                    <li class="list-group-item font-weight-bold rounded-0">
                        <span class="norm_name_day prod_norm">{{ preg_replace("/\([^)]+\)/","", $n->nt_desc) }} ({{ $n->j_acr }}) {{ $n->id_norma }}</span>
                        <div class="float-right">
                            <span class="d-inline-block">
                                <form action="{{ route('deactive.norm', ['id_norma' => $n->id_norma, 'id_tipo_norma' => $n->id_tipo_norma]) }}" method="POST">
                                    @csrf
                                    {{ method_field('PUT') }}
                                    <button class="btn btn-link p-0 m-0 text-white"><i class="fas fa-eye"></i></button>
                                </form>
                            </span>
                            <span class="d-inline-block pl-2">
                                <a href="{{ route('get.put.norm', ['id_norma' => $n->id_norma, 'id_tipo_norma' => $n->id_tipo_norma] ) }}"><i class="fas fa-edit"></i></a>
                            </span>
                            <span class="d-inline-block pl-2">
                                <form action="{{ route('delete.norm', ['id_norma' => $n->id_norma, 'id_tipo_norma' => $n->id_tipo_norma]) }}" method="POST" class="conf_form">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-link p-0 m-0 text-white"><i class="fas fa-trash"></i></button>
                                </form>
                            </span>
                        </div>
                    </li>       
                @endforeach
            </ul>
        </div> 
    @endforeach
@else
    <div class="card border-0 rounded-0 bg-transparent shadow-sm shadower" id="posted_norms">
        <div class="card-header border-0 rounded-0 bg-danger">
            <h5 class="header-title m-0 text-white">
                Ningúna norma ingresada
            </h5>
        </div>
    </div>
@endif