@extends('admin.layout.layout')

@section('title')
  Welcome page
@endsection

@section('content')
  <main>
    <h1 class="text-center">Laravel Training</h1>
    <p class="text-center">
      @if (Auth::check())
        <a href="{{ route('product.index') }}" class="btn btn-primary">
          Goto Product Manager
        </a>
      @else
        <a href="{{ route('showLogin') }}" class="btn btn-primary">
          Goto Login page
        </a>
      @endif

    </p>
  </main>
@endsection
