<h1>Header</h1>
<form action="{{ route('logout') }}" method="post">
  {{ csrf_field() }} {{ method_field('POST') }}
  <button class="btn btn-danger">
    Logout
  </button>

</form>
