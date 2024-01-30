<aside class="main-sidebar sidebar-dark-primary elevation-4">
<a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset('img/favicon.png') }}"
         alt="Logo de la empresa"
         class="brand-image img-circle elevation-3">
    <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
</a>


    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        @if(Auth::user()->imagen && file_exists(public_path('storage/img/usuario/' . Auth::user()->imagen)))
            <img src="{{ asset('storage/img/usuario/' . Auth::user()->imagen) }}"
                 class="img-circle elevation-2" alt="User Image">
        @else
            <!-- Si la imagen no existe, muestra la imagen predeterminada desde la carpeta default -->
            <img src="{{ asset('storage/img/default/anonymous.png') }}" class="img-circle elevation-2" alt="User Image">
        @endif
    </div>
    <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
    </div>
</div>


        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>
</aside>

