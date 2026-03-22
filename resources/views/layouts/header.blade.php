<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm ">
    <div class="container">

        <a class="navbar-brand brand-title" href="/">
            BMyHouse
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('tasks*') ? 'active' : '' }}" href="/tasks">
                        Tareas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('weekly-plans*') ? 'active' : '' }}" href="/weekly-plans">
                        Planes semanales
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('recipes*') ? 'active' : '' }}" href="/recipes">
                        Recetas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Lista compra</a>
                </li>
                @php
                    $user = \Illuminate\Support\Facades\Auth::user();
                @endphp
                @if($user)
                <li class="nav-item ms-4">
                    <form method="POST" action="{{ route('user.logout') }}">
                        @csrf
                        <button type="submit" class="p-0 border-0 bg-transparent text-light  mb-1" title="Cambiar usuario">
                            {{ $user->name }}
                            <i class="bi bi-box-arrow-right fs-5"></i>
                        </button>
                    </form>
                </li>
                @endif
            </ul>

        </div>
    </div>
</nav>