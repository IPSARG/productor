<nav class="navbar navbar-expand-lg navbar-light bg-white shadow">
    <div class="container-fluid">
        <a href="#" role="button" id="sidebarCollapse">
            <i class="fas fa-2x fa-bars text-dark"></i>
        </a>
        <span> Productor Trivia | <span class="section-name">@yield('section-title')</span></span>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                @if(session()->has('sit_user'))
                    {{ session()->get('sit_user')['email'] }} <i class="fas fa-xs fa-circle text-success pl-2"></i> 
                @endif
            </li>
        </ul>
    </div>
</nav>