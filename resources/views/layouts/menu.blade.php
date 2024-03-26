@php
namespace App\Http\Controllers;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;

$menus = DB::table('permisos')
    ->select('menu.id', 'menu.descripcion', 'menu.icono', 'menu.ruta','menu.orden')
    ->join('menu', 'menu.id', '=', 'permisos.menu_id')
    ->where('permisos.profile_id', Auth::user()->profile_id)
    ->where('menu.estado', '1')
    ->distinct()
    ->orderBy('menu.orden', 'asc')
    ->get();

@endphp
<!-- need to remove -->

<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ !Route::is('home.index') ?: 'active' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
@foreach ($menus as $item)
    @php
        $submenu = DB::table('permisos')
            ->select('submenu.menu_id', 'submenu.descripcion', 'submenu.ruta', 'submenu.orden', 'submenu.icono', 'submenu.estado', 'submenu.observaciones')
            ->join('menu', 'menu.id', '=', 'permisos.menu_id')
            ->join('submenu', 'submenu.menu_id', '=', 'menu.id')
            ->where('permisos.profile_id', Auth::user()->profile_id)
            ->where('submenu.menu_id', $item->id)
            ->where('submenu.estado', '1')
            ->distinct()
            ->orderBy('submenu.orden', 'asc')
            ->get();
    @endphp

    <li id="rutaMenu" class="nav-item">
        <a href="#" id="rutaMenu2{{ $loop->iteration }}" class="nav-link MenuClass{{ $loop->iteration }}"
            idRuta="{{ $item->ruta }}">
            <i class="{{ $item->icono }}"></i>
            <p>
                {{ $item->descripcion }}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @foreach ($submenu as $item2)
                <li class="nav-item">
                    <a href="{{ url($item2->ruta) }}" idRutaSubMenu="{{ $item2->ruta }}" id="SubMenu"
                        class="nav-link {{ !Route::is($item2->ruta . '.index') ?: 'active' }} subMenuClass"
                        onclick="activeMenu($item->ruta)">
                        <i class="{{ $item2->icono }}"></i>
                        <p>{{ $item2->descripcion }}

                        </p>
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
@endforeach
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-block btn-danger btn-lg" style="color: white">
        <i class="fas fa-power-off"></i> cerrar sesión
    </button>
</form>
