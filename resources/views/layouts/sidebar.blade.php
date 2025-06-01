<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/distribuidora.jpg') }}" alt="Distribuidora Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Distribuidora</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                 <a href="{{ route('admin.settings') }}" class="d-block nav-link {{ request()->routeIs('ventas.create') ? 'active' : '' }}">{{ Auth::user()->name }} <i class="fas fa-gear ml-2"></i> </a> 
                 <label class="d-block nav-link text-muted" style="font-size: 0.8rem;">
                    {{ Auth::user()->rol->descripcion }}
                 </label>
                
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('ventas.create') }}"
                        class="nav-link {{ request()->routeIs('ventas.create') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart col-2"></i>
                        <p>Cargar Venta</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ventas.index') }}"
                        class="nav-link {{ request()->routeIs('ventas.index') ? 'active' : '' }}">
                        <i class="fas fa-receipt col-2"></i>
                        <p>Ventas Realizadas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('clientes.index') }}"
                        class="nav-link {{ request()->routeIs('clientes.index') ? 'active' : '' }}">
                        <i class="fas fa-users col-2"></i>
                        <p>Clientes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('proveedores.index') }}"
                        class="nav-link {{ request()->routeIs('proveedores.index') ? 'active' : '' }}">
                        <i class="fas fa-truck col-2"></i>
                        <p>Proveedores</p>
                    </a>
                </li>
                @if (Auth::user()->rol->id === 1)
                    <li class="nav-item">
                        <a href="{{ route('productos.index') }}"
                            class="nav-link {{ request()->routeIs('productos.index') ? 'active' : '' }}">
                            <i class="fas fa-box col-2"></i>
                            <p>Productos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empresa.show', ['empresa' => 1]) }}"
                            class="nav-link {{ request()->routeIs('empresa.show') ? 'active' : '' }}">
                            <i class="fas fa-building col-2"></i>
                            <p>Datos de la Empresa</p>
                        </a>
                    </li>
                    <div class="bg-secondary" style="height: 1px; margin: 10px 0;"></div>

                    <li class="nav-item">
                        <a href="{{ route('user.index') }}"
                            class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}">
                            <i class="fas fa-users col-2"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
