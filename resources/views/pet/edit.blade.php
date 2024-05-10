@extends('layouts.app')

@section('title') @lang('Szukaj zwierzaka') @endsection

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
            <a class="nav-link active" aria-current="page" href="{{ route('pet.index') }}">@lang('Zwierzątka')</a>
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
        <h3 class="text-center">@lang('Edytuj zwierzaka')</h3>
          @if (isset($data['code']) && $data['code'] === 1)
          <div class="alert alert-danger" role="alert">
            @lang('Nie znaleziono zwierzaka z tym ID!')
          </div>
          <a class="btn btn-primary text-center" href="{{ route('pet.index') }}">@lang('Powrót')</a>
          @else
          <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">@lang('Edycja danych zwierzaka') </div>
                    <form action="{{ route('pet.update', $data['id']) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                                    <div class="form-group mb-2">
                                        <label class="required" for="name">@lang('Nazwa')</label>
                                        <input class="form-control @error('name') is-invalid @enderror" maxlength="255" type="text" name="name" id="name" value="{{ $data['name'] }}" required>
                                        @error('name')
                                            <div class="text-danger w-100 d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="required" for="category">@lang('Rasa')</label>
                                        <input class="form-control @error('category') is-invalid @enderror" maxlength="255" type="text" name="category" id="category" value="@isset($data['category']['name']) {{ $data['category']['name'] }} @endisset" required>
                                        @error('category')
                                            <div class="text-danger w-100 d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="required" for="status">@lang('Stan zwierzaka')</label>
                                        <input class="form-control @error('status') is-invalid @enderror" type="text" name="status" id="status" value="@isset($data['status']) {{ $data['status'] }} @endisset" required>
                                        @error('status')
                                            <div class="text-danger w-100 d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="required" for="tags">@lang('Tagi')</label>
                                        <input class="form-control @error('tags') is-invalid @enderror" maxlength="255" type="text" name="tags" id="tags" value="{{ $tags }}" required>
                                        @error('tags')
                                            <div class="text-danger w-100 d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="required" for="image">@lang('Zmień zdjęcie')</label>
                                        <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" accept="image/*">
                                        @error('image')
                                            <div class="text-danger w-100 d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                          </div>
                          <div class="card-footer">
                              <a href="{{ route('pet.index', 'id='.$data['id']) }}" class="btn btn-secondary">@lang('Powrót')</a>
                              <button class="btn btn-success ms-3">@lang('Zapisz zmiany')</button>
                          </div>
                    </form>
                  </div>
            </div>
          </div>
          @endif
  </section>

@endsection

@section('script')
<script>
    let tags = new Choices(document.getElementById('tags'),
          {
            placeholder:true,
            placeholderValue: 'Wpisz tag...',
            allowHTML: true,
            delimiter: '|',
            editItems: true,
            removeItemButton: true,
          }
        );
</script>

@if (session('edited_pet'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Dane zwierzaka zostały zmienione pomyślnie!',
    showConfirmButton: false,
    timer: 3000
});
</script>
@endif


@endsection
