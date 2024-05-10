@extends('layouts.app')

@section('title') @lang('Błąd :error - Nie znaleziono', ['error' => 404]) @endsection

@section('content')

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('pet.index') }}">@lang('Pet Store')</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('main') }}">@lang('Strona główna')</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('pet.index') }}">@lang('Zwierzątka')</a>
          </li>
        </ul>
        <ul class="navbar-nav d-flex mb-2 mb-lg-0">
            @auth
            <li class="nav-item">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-primary">@lang('Wyloguj się')</a>
              </li>
            @endauth
            @guest
            <li class="nav-item">
                <a class="btn btn-outline-primary" href="{{ route('login') }}">@lang('Zaloguj się')</a>
              </li>
              <li class="nav-item ms-2">
                <a class="btn btn-primary" href="{{ route('register') }}">@lang('Zarejestruj się')</a>
              </li>
            @endguest
          </ul>
      </div>
    </div>
  </nav>

  <section class="mt-5">
        <h1 class="text-center">@lang('Błąd :error - Nie znaleziono', ['error' => 404])</h3>
        <a href="{{ route('main') }}" class="btn btn-primary text-center">@lang('Powrót do strony głównej')</a>
  </section>

@endsection
