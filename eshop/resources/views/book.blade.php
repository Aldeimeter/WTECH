@extends('layouts.app')

@section('content')
<main class="container mt-3">
    <div class="row">
        <div class="col-12 col-lg-2 mb-3">
            <a href="{{ url()->previous() }}" role="button" class="btn btn-outline-secondary"><--- Späť</a>
        </div>
    </div>
    <div class="card">
        @if(!empty($book))
        <h3 class="card-header">{{$book->name}}</h3>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="carousel slide carousel-fade" data-bs-ride="carousel" id="images-carousel">
                        <div class="carousel-inner">
                            @forelse($images as $img)
                            <div class="carousel-item active ratio ratio-1x1"">
                     <img src="{{URL::asset('/img/' . $img->id)}}" alt="{{$img->alt_text}}" class="d-block w-100 img-thumbnail">
                            </div>
                            @empty
                            <p>Nie je žiaden obrazok.</p>
                            @endforelse
                        </div>
                        <button type="button" class="carousel-control-prev" data-bs-target="#images-carousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button type="button" class="carousel-control-next" data-bs-target="#images-carousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-lg-7 mx-auto ">
                    <div class="row border rounded-5 p-3 mt-3 mt-lg-0">
                        <div class="col-12">
                            <h5>Opis</h5>
                            <p>{{$book->description}}</p>
                        </div>
                        <div class="col-12 col-md-6 mt-3 text-center fs-3">
                            <span>Cena: {{$book->price}}$</span>
                            <div class="input-group">
                                @if($amount > 1)
                                <a id="decrement" class="btn" href="{{route('books.book', ['id' => $book->id, 'amount' => ($amount - 1)])}}">-</a>
                                @else
                                <a id="decrement" class="btn" href="">-</a>
                                @endif
                                <input type="number" id="input" value="{{$amount}}" class="form-control" readonly>
                                <a id="increment" class="btn" href="{{route('books.book', ['id' => $book->id, 'amount' => ($amount + 1)])}}">+</a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mt-3 text-center fs-3">
                            <span id="sum">Suma: {{$book->price * $amount}}$</span><br>
                            @if(Auth::check())
                            <a href="{{ route('cart.create', ['bookid' => $book->id, 'amount' => $amount]) }}" role="button" class="btn btn-lg btn-success">Kupit</a>
                            <a href="{{ route('cart.create', ['bookid' => $book->id, 'amount' => $amount]) }}" role="button" class="btn btn-lg btn-outline-success">Pridat do košíka</a>
                            @else
                            <a href="#" role="button" class="btn btn-lg btn-secondary">Kupit</a>
                            <a href="#" role="button" class="btn btn-lg btn-outline-secondary">Pridat do košíka</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer row mx-0">
            <div class="col-4">
                Autor:
                @forelse($book->authors as $author)
                <span class="badge bg-secondary">{{$author->fullname}}</span>
                @empty
                <span class="badge bg-secondary">Anonymný</span>
                @endforelse
            </div>
            <div class="col-4">
                Jazyk:
                <span class="badge bg-secondary">{{$book->language == 'SVK' ? 'Slovensky' : 'Anglicky'}}</span>
            </div>
            <div class="col-4">
                Žánre:
                @forelse($book->genres as $genre)
                <span class="badge bg-secondary">{{$genre->name}}</span>
                @empty
                <span class="badge bg-secondary">Žiadne žánre</span>
                @endforelse
            </div>
        </div>
        @else
        <h3 class="card-header">Kniha nebola nájdená</h3>
        @endif
    </div>
</main>

@endsection
