@extends('layouts.app')

@section('title') @lang('Zarejestruj się') @endsection

@section('body')
    class="bg-body-tertiary"
@endsection

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
                <a class="btn btn-outline-primary">@lang('Wyloguj się')</a>
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
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-9">
          <h1 class=" mb-4">@lang('Zarejestruj się')</h1>
          <div class="card" style="border-radius: 15px;">
            <div class="card-body">
              <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="row align-items-center pt-4 pb-3">
                    <div class="col-md-3 ps-5">
                      <h6 class="mb-0">@lang('Nazwa użytkownika')</h6>
                    </div>
                    <div class="col-md-9 pe-5">
                      <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name') }}" required/>
                      @error('name')
                        <div class="text-danger w-100 d-block">
                            {{ $message }}
                        </div>
                    @enderror
                    </div>
                  </div>
                  <hr class="mx-n3">
                  <div class="row align-items-center py-3">
                    <div class="col-md-3 ps-5">
                      <h6 class="mb-0">@lang('Adres email')</h6>
                    </div>
                    <div class="col-md-9 pe-5">
                      <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="example@example.com" value="{{ old('email') }}" required />
                      @error('email')
                        <div class="text-danger w-100 d-block">
                            {{ $message }}
                        </div>
                    @enderror
                    </div>
                  </div>
                  <hr class="mx-n3">
                  <div class="row align-items-center py-3">
                    <div class="col-md-3 ps-5">
                      <h6 class="mb-0">@lang('Hasło')</h6>
                    </div>
                    <div class="col-md-9 pe-5">
                        <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Wprowadź hasło" required/>
                        <input type="password" name="password_confirmation" class="form-control form-control-lg mt-3" placeholder="Powtórz hasło" required/>
                        @error('password')
                        <div class="text-danger w-100 d-block">
                            {{ $message }}
                        </div>
                    @enderror
                    </div>
                  </div>
                  <hr class="mx-n3">
                  <div class="px-5 py-4">
                    <button type="submit" class="btn btn-primary btn-lg">@lang('Zarejestruj się')</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
