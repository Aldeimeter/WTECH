@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-xl-2 bg-primary bg-opacity-25 p-3 fs-5 text-center">
    {{ $genre->name }}</div>
    <div class="col-xl-10 bg-success bg-opacity-10 ps-5 py-3 fs-5 text-center text-xl-start">Vyhľadávací dotaz</div>
    </div>

  <div class="row mt-3">
    <div class="col-12 col-lg-2 p-0">
      <div class="d-grid">
        <button type="button" class="btn btn-secondary d-lg-none" data-bs-toggle="collapse" data-bs-target="#filters-collapse" aria-controls="filters-collapse" aria-expanded="false">Filtre</button>
      </div>
        <div class="collapse d-lg-block" id="filters-collapse">
        <form class="row my-3" method="GET">
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
                <button type="submit" class="btn btn-outline-secondary">Použiť filtre</button>
              </div>
        </form>
      </div>
    </div>
    <div class="col-12 col-lg-9 mx-auto p-0">
        @forelse ($results as $book)
            <div class="card">
                <div class="row g-0 my-3 mb-md-2 mt-md-0">
                    <div class="col-md-4">
                        <img src="{{URL::asset('/img/' . $book->imageid)}}" alt="{{$book->name}}" class="d-block w-100 img-thumbnail">
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
                                    <span>{{ $book->language }}</span>
                                    <!-- Adjust the link as necessary -->
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
