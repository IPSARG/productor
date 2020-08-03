<div class="card border-0 rounded-0 shadow-sm shadower" id="sit_finalized">
    <div class="card-header border-0 rounded-0 bg-dark">
        <h4 class="header-title m-0 text-white">Cabezal armado SIT <span class="badge badge-pill badge-danger float-right">{{ count($sitNorms) }}</span></h4>
    </div>
    <ul class="list-group list-group-flush">
        @if(count($sitNorms) > 0)
            @foreach ($sitNorms as $norm)
                <li class="list-group-item font-weight-bold rounded-0 bg-secondary">
                    <span class="norm_name_day text-white sit_norm">{{ $norm->nt_name }} ({{ $norm->j_acr }}) {{ str_replace('.', '',$norm->number) }} </span>
                </li>
            @endforeach
        @else
            <li class="list-group-item font-weight-bold rounded-0 bg-secondary">
                <span class="norm_name_day text-white sit_norm"> Ningúna norma presente </span>
            </li>
        @endif
    </ul>
</div>   