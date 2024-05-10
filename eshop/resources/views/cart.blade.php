@extends('layouts.app')

@section('content')
<main><br /><br /><br />
    <div class="container">
        <div class="row col-12">
            <div class="col col-12 col-lg-3 col-md-4 ">
                <div class="row">
                    <div class="col">
                        <div class="card align-items-center">
                            <h5 class="card-title text-center mt-3 mb-3">Košík</h5>
                        </div>
                        <div class="card mt-5 mb-5">
                            <div class="card-body">
                                <form method="GET" action="/order/create">
                                    <label for="address" class="form-label">Adresa</label>
                                    <input name="address" type="text" id="address" class="form-control" required>

                                    <label for="delivery" class="form-label">Druh doručenia</label>
                                    <select name="delivery" id="delivery" class="form-select">
                                        <option value="1">Slovak Post</option>
                                        <option value="2">Packeta</option>
                                        <option value="3">AlzaBox</option>
                                    </select>

                                    <label for="payment" class="form-label">Druh platby</label>
                                    <select name="payment" id="payment" class="form-select">
                                        <option value="1">Bankový účet</option>
                                        <option value="2">Google Pay</option>
                                        <option value="3">Apple Pay</option>
                                    </select>

                                    <label for="cost" class="form-label">
                                        <h5 class="mt-3">Celková cena</h5>
                                    </label>
                                    <input type="text" id="cost" readonly value="{{$total}}$" class="form-control form-control-plaintext">
                                    <div class="row justify-content-center">
                                        @if(Auth::check())
                                        <button class="btn btn-primary btn-lg mt-3">Kúpiť</button>
                                        @else
                                        <button class="btn btn-secondary btn-lg mt-3" disabled>Kúpiť</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-md-8">
                <div class="row">
                    <div class="col">
                        @forelse ($cartitems as $book)
                        <div class="card mb-3">
                            <div class="row">
                                <div class="d-none d-sm-block col-3 " style="background-image: url(../img/sogun_2.jpeg); background-position-x:center;">
                                </div>
                                <div class="col-9 d-flex ">
                                    <div class="card-body flex-column">
                                        <h4 class="card-title mt-2"><a href="books/{{$book->id}}">{{$book->fullname}} - {{$book->name}}</a></h4>
                                        <ul class="list-group list-group-horizontal mt-4" style="width:inherit">
                                            <li style="display:flex; flex-direction: column;" class="list-group-item justify-content-center">
                                                <p class="mb-0">{{$book->price}}$</p>
                                            </li>
                                            <li class="list-group-item justify-content-center" style="display:flex; flex-direction: column;">
                                                <div class="btn-group">
                                                <form method="POST" action="/cart/{{$book->ciid}}?amount={{$book->amount - 1}}">
                                                    {{method_field("PUT")}}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-secondary">-</button>
                                                </form>
                                                    <button class="btn btn-secondary">{{$book->amount}}</button>
                                                <form method="POST" action="/cart/{{$book->ciid}}?amount={{$book->amount + 1}}">
                                                    {{method_field("PUT")}}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-secondary">+</button>
                                                </form>
                                                </div>
                                            </li>
                                            <li style="display:flex; flex-direction: column;" class="list-group-item justify-content-center">
                                                <p class="mb-0">{{$book->price * $book->amount}}$</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            @if(Auth::check())
                            <p>Nemáte nič v košiku</p>
                            @else
                            <p>Nie ste prihlásení</p>
                            @endif
                        @endforelse
                        {{$cartitems->links('vendor.pagination.bootstrap-5')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
