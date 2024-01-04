<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background: #2a2a2e !important; ">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
      aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
      <img src="{{ asset('img/logo_text.png') }}" class="img-fluid" alt="RIVERCRANE VIETNAM">
    </a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="{{ route('user.index') }}">Users</a>
        <a class="nav-link" href="{{ route('product.index') }}">Sản phẩm</a>
      </div>

      <form class="ms-auto" action="{{ route('logout') }}" method="post">
        <span class="text-white me-3">{{ Auth::user()->name }}</span>
        {{ csrf_field() }} {{ method_field('POST') }}
        <button class="btn btn-danger">
          Logout
        </button>

      </form>

    </div>




  </div>
</nav>
