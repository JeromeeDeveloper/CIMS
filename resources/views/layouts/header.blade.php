<!DOCTYPE html>
<html>
<head>
<style>
  
  .navbar-nav {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .nav-link {
    margin-right: 20px;
  }

  .nav-link a {
    text-decoration: none;
    color: #fff;
    font-weight: bold;
    padding: 8px 12px;
    border-radius: 4px;
    background-color: #0A1931;
    transition: background-color 0.3s;
  }

  .nav-link a:hover {
    background-color: #9E6F21; 
  }
</style>
</head>
<body>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
     
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-link active">
        @if(Auth::user()->role == 1)
        <a href="{{ route('users.index') }}">GOOD DAY! {{ auth()->user()->name}}</a>
        @endif
        @if(Auth::user()->role == 2)
        <a href= "#">GOOD DAY! {{ auth()->user()->name}}</a>
        @endif
      </li>
    </ul>
</nav>

</body>
</html>
