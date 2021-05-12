<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title??'inconnu' }} - School admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('mazer/assets/css/bootstrap.css') }}">
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('mazer/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('mazer/assets/images/favicon.svg') }}" type="image/x-icon">
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="/"><img src="{{ asset('mazer/assets/images/logo/logo.png') }}" alt="Logo" srcset=""></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item  {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Tableau de bord</span>
                            </a>
                        </li>

                        <li class="sidebar-item  {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.teachers.index') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Enseignants</span>
                            </a>
                        </li>

                        <li class="sidebar-item  {{ request()->routeIs('admin.cycles.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.cycles.index') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Cycles</span>
                            </a>
                        </li>

                        <li class="sidebar-item  {{ request()->routeIs('admin.levels.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.levels.index') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Niveaux</span>
                            </a>
                        </li>

                        <li class="sidebar-item  {{ request()->routeIs('admin.classrooms.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.classrooms.index') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Salles de classe</span>
                            </a>
                        </li>

                        <li class="sidebar-item  {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.courses.index') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Matières</span>
                            </a>
                        </li>

                        <li class="sidebar-item  {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.students.index') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Elèves</span>
                            </a>
                        </li>

                        <li class="sidebar-item  {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Utilisateurs</span>
                            </a>
                        </li>

                        <li class="sidebar-item  {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.roles.index') }}" class='sidebar-link'>
                                <i class="bi bi-people-fill"></i>
                                <span>Roles et permissions</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main" class='layout-navbar'>
            <header class='mb-3'>
                <nav class="navbar navbar-expand navbar-light ">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>
                        <small class="text-sm ml-2">
                           Année:{{ $academicYear->name }}
                        </small>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                
                            </ul>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600">{{ auth()->user()->name }}</h6>
                                            <p class="mb-0 text-sm text-gray-600">{{ auth()->user()->roles[0]->name }}</p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                @if (empty(auth()->user()->avatar))
                                                <img src="{{ asset('images/default-user.jpg') }}">
                                                @else
                                                <img src="{{ auth()->user()->avatar->getUrl('avatar-thumb') }}">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <h6 class="dropdown-header">Bonjour, {{ auth()->user()->name }}!</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i> My
                                            Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i>
                                            Paramètres</a></li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a onclick="event.preventDefault();document.getElementById('logoutForm').submit();" class="dropdown-item" href="#"><i
                                                class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none">
                                        @csrf
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <div id="main-content">

                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>{{ $title }}</h3>
                                <p class="text-subtitle text-muted">Description de la page</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html">School Admin</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    @yield('content')
                </div>

                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2021 &copy; Mazer</p>
                        </div>
                        <div class="float-end">
                            <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                                by <a href="https://ahmadsaugi.com">Saugi</a></p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="{{ asset('mazer/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('mazer/assets/js/bootstrap.bundle.min.js') }}"></script>
    @yield('scripts')
    <script src="{{ asset('mazer/assets/js/main.js') }}"></script>
</body>

</html>