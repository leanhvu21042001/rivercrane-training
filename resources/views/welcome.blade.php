@extends('admin.layout.layout')

@section('title')
  Welcome page
@endsection

@section('content')
  <main>
    <h1 class="text-center">Laravel Training</h1>
    <p class="text-center">
      <a href="{{ route('showLogin') }}" class="btn btn-primary">
        Goto Login page
      </a>
    </p>
  </main>
@endsection
