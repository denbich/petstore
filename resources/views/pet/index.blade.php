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
        <h3 class="text-center">@lang('Szukaj zwierzaka')</h3>
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <form class="d-flex" role="search" method="get" action="{{ route('pet.index') }}">
                    <input class="form-control me-2"
                    type="number"
                    name="id"
                    placeholder="Wprowadź ID zwierzaka"
                    aria-label="Search"
                    min="0"
                    value="@if (session('created_pet')){{ session('petId') }}@elseif(isset($_GET['id'])){{ $_GET['id'] }}@endif"
                    >
                    <button class="btn btn-outline-success" type="submit">@lang('Szukaj')</button>
                    <div class="mx-2 w-100" style="border-left:1px solid #000;">
                        <button class="btn btn-primary w-100 ms-2" type="button" data-bs-toggle="modal" data-bs-target="#createModal">@lang('Dodaj nowego zwierzaka')</button></div>

                  </form>
                  <hr>
            </div>
        </div>
          @isset($data)
            @if (isset($data['code']) && $data['code'] === 1)
            <div class="alert alert-danger" role="alert">
                @lang('Nie znaleziono zwierzaka z tym ID!')
            </div>
            @else
            <div class="card">
                <div class="card-header">@lang('Dane zwierzaka') </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        @if (count($data['photoUrls']) > 0)
                            <img src="{{ $data['photoUrls'][0] }}" alt="zdjecie zwierzaka" class="img-fluid">
                        @else
                        <h4 class="text-center">@lang('Brak zdjęcia!')</h4>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <p>@lang('Imię:')<b> {{ $data['name'] }}</b></p>
                        <p>@lang('Rasa:')<b>
                            @if (isset($data['category']['name']))
                                {{ $data['category']['name'] }}
                            @else
                                @lang('Brak rasy')
                            @endif
                        </b></p>
                        <p>@lang('Status:')<b>
                            @if (isset($data['status']))
                                {{ $data['status'] }}
                            @else
                                @lang('Brak statusu')
                            @endif
                        </b></p>
                        <p>@lang('Tagi:')</p>
                        <ul>
                            @forelse ($data['tags'] as $tag)
                                <li>{{ $tag['name'] }}</li>
                            @empty
                                <li>@lang('Brak tagów')</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('pet.edit', $_GET['id']) }}" class="btn btn-primary">@lang('Edytuj dane zwierzaka')</a>
                    <button class="btn btn-danger ms-3" data-bs-toggle="modal" data-bs-target="#deleteModal">@lang('Usuń zwierzaka')</button>
                </div>
            </div>
            @endif
          @endisset
  </section>

  @if (!isset($data['code']) || $data['code'] != 1)
  {{-- Create Modal --}}
  <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createModalLabel">@lang('Utwórz nowego zwierzaka')</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('pet.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="form-group mb-2">
                <label class="required" for="name">@lang('Nazwa')</label>
                <input class="form-control @error('name') is-invalid @enderror" maxlength="255" type="text" name="name" id="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger w-100 d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group mb-2">
                <label class="required" for="category">@lang('Rasa')</label>
                <input class="form-control @error('category') is-invalid @enderror" maxlength="255" type="text" name="category" id="category" value="{{ old('category') }}" required>
                @error('category')
                    <div class="text-danger w-100 d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group mb-2">
                <label class="required" for="status">@lang('Stan zwierzaka')</label>
                <input class="form-control @error('status') is-invalid @enderror" type="text" name="status" id="status" value="{{ old('status') }}" required>
                @error('status')
                    <div class="text-danger w-100 d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group mb-2">
                <label class="required" for="tags">@lang('Tagi')</label>
                <input class="form-control @error('tags') is-invalid @enderror" maxlength="255" type="text" name="tags" id="tags" value="{{ old('tags') }}" required>
                @error('tags')
                    <div class="text-danger w-100 d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group mb-2">
                <label class="required" for="image">@lang('Zdjęcie')</label>
                <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" accept="image/*" required>
                @error('image')
                    <div class="text-danger w-100 d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Zamknij')</button>
            <button type="submit" class="btn btn-success">@lang('Utwórz')</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @isset($data)
      {{-- Delete Modal --}}
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="deleteModalLabel">@lang('Usuń zwierzaka')</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h3 class="text-center">@lang('Czy jesteś pewnież, że chcesz usunąć zwierzaka o imieniu :name?', ['name' => $data['name']])</h3>
            <h5 class="text-danger text-center">@lang('Tego procesu nie da się cofnąć!')</h5>
          </div>
          <form action="{{ route('pet.destroy', $_GET['id']) }}" method="post">
            @csrf
            @method('delete')
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Zamknij')</button>
            <button type="submit" class="btn btn-danger">@lang('Usuń')</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endisset

  @endif

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

@if (session('created_pet'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Zwierzak został dodany pomyślnie!',
    showConfirmButton: false,
    timer: 3000
});
</script>
@endif

@if (session('deleted_pet'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Zwierzak został usunięty pomyślnie!',
    showConfirmButton: false,
    timer: 3000
});
</script>
@endif

@if (session('error_deleting_pet'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Wystąpił błąd podczas usuwania zwierzaka!',
    showConfirmButton: false,
    timer: 3000
});
</script>
@endif

@if ($errors->any())
<script>
    $(document).ready(function(){
        $('createModal').modal('show');
    });
</script>
@endif

@endsection
