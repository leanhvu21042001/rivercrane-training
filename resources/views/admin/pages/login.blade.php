@extends('admin.layout.layout')

@section('title')
  Login page
@endsection


@section('content')
  <main class="vh-100 d-flex">
    <div class="card w-25 m-auto ">
      <div class="card-body">
        <p class="text-danger text-center">
          @error('errorBack')
            {{ $message }}
          @enderror
        </p>
        <form method="POST" action="{{ route('doLogin') }}">
          {{ csrf_field() }} {{ method_field('POST') }}

          <div class="mb-3">
            <label for="emailInput" class="form-label">Email address</label>
            <input name="email" type="email" value="{{ old('email') }}" class="form-control" id="emailInput">

            <p class="text-danger">
              @error('email')
                {{ $message }}
              @enderror
            </p>

          </div>

          <div class="mb-3">
            <label for="passwordInput" class="form-label">Password</label>
            <input name="password" type="password" value="{{ old('password') }}" class="form-control" id="passwordInput">
            <p class="text-danger">
              @error('password')
                {{ $message }}
              @enderror
            </p>
          </div>

          <div class="d-flex flex-row justify-content-between">
            <div class="mb-3 form-check">
              <input name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} class="form-check-input"
                id="remember">
              <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary" name="login" value="login">Submit</button>
          </div>

        </form>
      </div>
    </div>
  </main>
@endsection
