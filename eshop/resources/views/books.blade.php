@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-xl-2 bg-primary bg-opacity-25 p-3 fs-5 text-center">
     {{ $genre->name }}</div>

    <div class="col-xl-10 bg-success bg-opacity-10 ps-5 py-3 fs-5 text-center text-xl-start">{{$searchQuery}}</div>
    </div>

  <div class="row mt-3">
    <div class="col-12 col-lg-2 p-0">
      <div class="d-grid">
        <button type="button" class="btn btn-secondary d-lg-none" data-bs-toggle="collapse" data-bs-target="#filters-collapse" aria-controls="filters-collapse" aria-expanded="false">Filtre</button>
      </div>
        <div class="collapse d-lg-block container p-0" id="filters-collapse">
            <form action="{{ route('books.search') }}" method="GET" class="row my-3">
                <div>
                    <label for="q" class="visually-hidden">Vyhľadávanie</label>
                    <input class="form-control text-center text-md-start mb-2 col-8" type="text" name="q" placeholder="Vyhľadávanie" aria-label="Search" value="{{ request('q') }}">
                    <button class="form-control btn btn-outline-success mb-2" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </button>
                </div>
                <div>
                    <select name="genre" class="form-select">
                        <option value="all" {{request('genre') == 'all' ? 'selected' : ''}}>Všetky žánre</option>
                        @if($genres->isNotEmpty())
                            @foreach($genres as $genre)
                                <option value="{{ $genre->slug }}" {{request('genre') == $genre->slug ? 'selected' : ''}}>{{ $genre->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                  <div class="col-6 my-lg-3 my-1">
                    <label for="price-from" class="form-label">Od</label>
                    <input type="number" name="price-from" class="form-control border border-secondary" id="price-from" placeholder="10" value="{{request('price-from')}}">
                  </div>
                  <div class="col-6 my-lg-3 my-1">
                    <label for="price-to"class="form-label">Do</label>
                    <input type="number" name="price-to" class="form-control border border-secondary" id="price-to" placeholder="1000" value="{{request('price-to')}}">
                  </div>
                  <div class="col-12 my-lg-3 my-1">
                    <label for="date" class="form-label">Dátum od</label>
                    <input type="date" name="date" class="form-control border border-secondary" id="date" placeholder="10.03.2023" value="{{request('date')}}">
                  </div>
             {{-- Language Select --}}
                <div class="col-12 my-lg-3 my-1">
                    <select class="form-select border border-secondary" id="language" name="language">
                        <option value="any" {{ request('language') == 'any' ? 'selected' : '' }}>Ľubovoľný jazyk</option>
                        <option value="SVK" {{ request('language') == 'SVK' ? 'selected' : '' }}>Slovensky</option>
                        <option value="ENG" {{ request('language') == 'ENG' ? 'selected' : '' }}>Anglicky</option>
                    </select>
                </div>

                {{-- Order Select --}}
                <div class="col-12 my-lg-3 my-1">
                    <select class="form-select border border-secondary" id="order" name="order">
                        <option value="no order" {{ request('order') == 'no order' ? 'selected' : '' }}>Preusporiadanie</option>
                        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Cena vzostupne</option>
                        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Cena zostupne</option>
                    </select>
                </div>
                  <div class="col-12 my-lg-3 my-1">
                    <button type="submit" class="form-control btn btn-outline-secondary">Použiť filtre</button>
                  </div>
            </form>
      </div>
    </div>
    <div class="col-12 col-lg-9 mx-auto p-0">
        @forelse ($results as $book)
            <div class="card">
                <div class="row g-0 my-3 mb-md-2 mt-md-0">
                    <div class="col-md-4">
<img src="{{ $book->images->first() ? URL::asset('/img/' . $book->images->first()->id) : URL::asset('/img/default.png') }}" alt="{{ $book->name }}" class="d-block w-100 img-thumbnail">
                    </div>
                    <div class="col-md-8">
                        <h5 class="card-header"><a href="/books/{{$book->id}}">{{ $book->name }}</a></h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="text-wrap">{{ $book->description }}</p>
                                    <span>{{ $book->price  }} $</span>
                                </div>
                                <div class="col-md-4">
                                    <span>{{ $book->language == 'SVK' ? 'Slovensky' : 'Anglicky' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>No books found.</p>
        @endforelse
        {{ $results->links('vendor.pagination.bootstrap-5') }}
  </div>
</div>
@endsection
