<nav aria-label="breadcrumb">
    <ol class="breadcrumb rounded-pill">
        @if(session()->has('main_indtem'))
            <li class="breadcrumb-item">
                <a class="text-decoration-none font-weight-bold text-secondary">{{ session()->get('main_indtem') }}</a>
            </li>
        @endif
        @foreach (session()->get('arrayDescNodo') as $crumb)
            <li class="breadcrumb-item">
                @if($loop->last)
                    <span class="font-weight-bold text-orange">{{ $crumb['desc'] }}</span>
                @elseif($crumb['url'] == 'coefi')
                    <a href="{{ route('get.tem.child.coe', ['CodNodo' => $crumb['code'], 'DescNodo' => $crumb['desc'], 'brcr' => true]) }}" class="text-decoration-none font-weight-bold text-trivia">{{ $crumb['desc'] }}</a>
                @else 
                    <a href="{{ route('get.tem.child', ['CodNodo' => $crumb['code'], 'DescNodo' => $crumb['desc'], 'brcr' => true]) }}" class="text-decoration-none font-weight-bold text-trivia">{{ $crumb['desc'] }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>