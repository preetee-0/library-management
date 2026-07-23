<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
    <style>
    body{
        background:#f4f6f9;
    }

    body,
    .card,
    .table,
    .form-control,
    .navbar,
    .list-group-item,
    .btn{
        transition: all 0.3s ease;
    }

    .card{
        border-radius:20px;
        transition: transform .3s ease, box-shadow .3s ease;
    }

    .card:hover{
        transform:translateY(-6px);
        box-shadow:0 12px 25px rgba(0,0,0,.25);
    }

    .btn{
        border-radius:25px;
    }

 
    body.dark-mode{
        background:#121212;
        color:white;
    }


    body.dark-mode .navbar{
        background:#000 !important;
    }


    body.dark-mode .card{
        background:#1f1f1f !important;
        color:white !important;
    }

    /* Card headers */
    body.dark-mode .card-header{
        color:white !important;
    }

    /* Table */
    body.dark-mode .table{
        color:white;
    }

    body.dark-mode .table-dark{
        --bs-table-bg:#2d2d2d;
    }

    body.dark-mode .table td,
    body.dark-mode .table th{
        border-color:#555;
    }

    /* Form */
    body.dark-mode .form-control{
        background:#2b2b2b;
        color:white;
        border-color:#666;
    }

    body.dark-mode .form-control::placeholder{
        color:#aaa;
    }

    /* List group */
    body.dark-mode .list-group-item{
        background:#2b2b2b;
        color:white;
        border-color:#555;
    }

    /* Links */
    body.dark-mode a{
        color:#8ab4f8;
    }

    /* Alerts */
    body.dark-mode .alert-success{
        background:#1b4332;
        color:white;
        border:none;
    }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-building"></i> Library
        </a>

        <div class="d-flex flex-wrap align-items-center">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light me-2 my-1">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <a href="{{ route('books.index') }}" class="btn btn-outline-light me-2 my-1">
                    <i class="bi bi-book"></i> Books
                </a>

                <a href="{{ route('borrow.index') }}" class="btn btn-outline-light me-2 my-1">
                    <i class="bi bi-clock-history"></i> Borrow History
                </a>
                
                <a href="{{ route('students.index') }}" class="btn btn-outline-light me-2 my-1">
                    <i class="bi bi-people"></i> Students
                </a>
                
                <a href="{{ route('waitlist.index') }}" class="btn btn-outline-light me-2 my-1">
                    <i class="bi bi-hourglass-split"></i> Waitlist
                </a>

                <a href="{{ route('books.create') }}" class="btn btn-warning me-2 my-1 text-dark">
                    <i class="bi bi-plus-circle"></i> Add Book
                </a>

                <form method="POST" action="{{ route('logout') }}" class="d-inline my-1">
                    @csrf
                    <button type="submit" class="btn btn-outline-light me-2">
                        <i class="bi bi-door"></i> Logout
                    </button>
                </form>

            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2 my-1">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary me-2 my-1">
                    <i class="bi bi-person-plus"></i> Register
                </a>
            @endauth

            <button id="themeToggle" class="btn btn-outline-light my-1">
                <i class="bi bi-moon"></i> Dark Mode
            </button>
        </div>

    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<footer class="app-footer mt-5 py-4 bg-dark">
    <div class="container">
        <div class="row align-items-center text-white">

            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="mb-1">
                    <i class="bi bi-building"></i> Library Management System
                </p>
                <p class="mb-0 small">
                    &copy; {{ date('Y') }} All rights reserved.
                </p>
            </div>

            <div class="col-md-6 text-center text-md-end">
                <p class="mb-1 fw-semibold">Contact us</p>
                <p class="mb-1 small">
                    <i class="bi bi-geo-alt"></i> Kupondole, Lalitpur
                </p>
                <p class="mb-1 small">
                    <i class="bi bi-telephone"></i> +977 9812637362
                </p>
                <p class="mb-0 small">
                    <i class="bi bi-envelope"></i> <a href="mailto:library@example.com" class="text-reset text-decoration-none">library@example.com</a>
                </p>
            </div>

        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('themeToggle');

    function setTheme(theme){
        if(theme === 'dark'){
            document.body.classList.add('dark-mode');
            button.innerHTML = '<i class="bi bi-sun"></i> Light Mode';
        }else{
            document.body.classList.remove('dark-mode');
            button.innerHTML = '<i class="bi bi-moon"></i> Dark Mode';
        }
        localStorage.setItem('theme', theme);
    }

    // Load saved theme
    setTheme(localStorage.getItem('theme') || 'light');

    // Toggle theme
    button.addEventListener('click', function(){
        if(document.body.classList.contains('dark-mode')){
            setTheme('light');
        }else{
            setTheme('dark');
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>