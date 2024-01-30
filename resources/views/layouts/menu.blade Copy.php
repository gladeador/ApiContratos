
@isset($menus)
    @isset($submenu)
        //do something with $menu
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ !Route::is('home.index') ?: 'active' }}">
                <i class="nav-icon fas fa-home"></i>
                <p>Home</p>
            </a>
        </li>
        @foreach ($menus as $item)
            <li class="nav-item {{ !Route::is($item->ruta . '.index') ?: 'has-treeview menu-open ' }}">
                {{-- <a id="rutaMenu" href="#" class="nav-link @if (Route::is('user.index') || Route::is('profile.index') || Route::is('permisos.index') || Route::is('prueba.index')) active @endif"> --}}
                <a id="rutaMenu" href="#" class="nav-link {{ !Route::is($item->ruta . '.index') ?: 'active' }}">
                    <i class="{{ $item->icono }}"></i>
                    <p>
                        {{ $item->descripcion }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach ($submenu as $item2)
                        <li class="nav-item">
                            <a href="{{ $item2->ruta }}"
                                class="nav-link {{ !Route::is($item2->ruta . '.index') ?: 'active' }}">
                                <i class="{{ $item2->icono }}"></i>
                                <p>{{ $item2->descripcion }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    @endisset
@endisset
