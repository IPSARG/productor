<div class="sidebar-header">
    <img src="http://trivia.ips.com.ar/img/logo_big.png" class="img-fluid w-75" alt="">
</div>
<ul class="list-unstyled components">
    <li class="{{ Route::is('index','get.put.norm', 'search.norms', 'search.norm.type', 'get.put.norm.type') ? 'active' : '' }}">
        <a href="{{ route('index') }}"><i class="fas fa-dot-circle pr-2 text-light"></i> Índice Numérico</a>
    </li>
    <li class="{{ Route::is('tem','get.tem.child', 'get.tem.child.legis', 'get.tem.child.coe', 'get.disp.NCl', 'get.disp.Cl', 'get.disp.coe', 'get.disp.cap') ? 'active' : '' }}">
        <a href="{{ url('materias-coes/filtrar?CodNodo=CP1&DescNodo=Tributaria%20nacional&Prim=true') }}"><i class="fas fa-dot-circle pr-2 text-light"></i> Materias y Coes</a>
    </li>
</ul>

@if(Request::is('materias-coes', 'materias-coes/*'))
    <ul class="list-unstyled components sub pt-0">
        <li>
            <a class="a-badge" href="{{ route('get.tem.child') . '?CodNodo=CP1&DescNodo=Tributaria%20nacional&Prim=true' }}">
                <span class="badge {{ Session::get('main_indtem') == 'Tributaria nacional' ? 'badge-secondary' : 'badge-primary' }} text-white badge-pill py-2 px-3">Tributaria Nacional</span>
            </a>
        </li>
        <li>
            <a class="a-badge" href="{{ route('get.tem.child') . '?CodNodo=A11534&DescNodo=Tributaria%20provincial&Prim=true' }}">
                <span class="badge {{ Session::get('main_indtem') == 'Tributaria provincial' ? 'badge-secondary' : 'badge-primary' }} text-white badge-pill py-2 px-3">Tributaria Provincial</span>
            </a>
        </li>
        <li>
            <a class="a-badge" href="{{ route('get.tem.child.legis') . '?CodNodo=A25994&DescNodo=Comercial&Prim=true' }}">
                <span class="badge {{ Session::get('main_indtem') == 'Comercial' ? 'badge-secondary' : 'badge-primary' }} text-white badge-pill py-2 px-3">Comercial</span>
            </a>
        </li>
        <li>
            <a class="a-badge" href="{{ route('get.tem.child.legis') . '?CodNodo=A25692&DescNodo=Laboral%20y%20Seg.%20Social&Prim=true' }}">
                <span class="badge {{ Session::get('main_indtem') == 'Laboral y Seg. Social' ? 'badge-secondary' : 'badge-primary' }} text-white badge-pill py-2 px-3">Laboral y Seg. Social</span>
            </a>
        </li>
        <li>
            <a class="a-badge" href="{{ route('get.tem.child.legis') . '?CodNodo=A44063&DescNodo=Societaria&Prim=true' }}">
                <span class="badge {{ Session::get('main_indtem') == 'Societaria' ? 'badge-secondary' : 'badge-primary' }} text-white badge-pill py-2 px-3">Societaria</span>
            </a>
        </li>
        <li>
            <a class="a-badge" href="{{ route('get.tem.child.coe') . '?CodNodo=CP0&DescNodo=%C3%ADndices%20y%20Tasas&Prim=true' }}">
                <span class="badge {{ Session::get('main_indtem') == 'índices y Tasas' ? 'badge-secondary' : 'badge-primary' }}  text-white badge-pill py-2 px-3">Índices y Tasas</span>
            </a>
        </li>
        <li>
            <a class="a-badge" href="{{ route('get.tem.child') . '?CodNodo=A102565&DescNodo=Contabilidad%20y%20Auditor%C3%ADa&seccion=15&Prim=true' }}">
                <span class="badge {{ Session::get('main_indtem') == 'Contabilidad y Auditoría' ? 'badge-secondary' : 'badge-primary' }} text-white badge-pill py-2 px-3">Contabilidad y Auditoría</span>
            </a>
        </li>
    </ul>
@endif