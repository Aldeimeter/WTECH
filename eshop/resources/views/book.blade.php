@extends('layouts.app')

@section('content')
<main class="container mt-3">
    <div class="row">
        <div class="col-12 col-lg-2 mb-3">
            <a href="#" role="button" class="btn btn-outline-secondary"><--- Späť</a>
        </div>
    </div>
    <div class="card">
        <h3 class="card-header">Nazov Knihy</h3>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="carousel slide carousel-fade" data-bs-ride="carousel" id="images-carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active ratio ratio-1x1"">
                     <img src=" ../img/AUD01576.webp" alt="Šógun - Audiokniha MP3 - Hlavný obrázok" class="d-block w-100 img-thumbnail">
                            </div>
                            <div class="carousel-item ratio ratio-1x1"">
                     <img src=" ../img/sogun_2.jpeg" alt="" class="d-block w-100 img-thumbnail">
                            </div>
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
                            <p>Příběh o vesmírném hvězdoletu Prométheus a jeho odvážné posádce, která pomůže osvobodit Zemi od nadvlády robotů, se v hlavě Václava Šorela začal rodit v sedmdesátých letech 20. století. Ve spolupráci s ilustrátorem Františkem Kobíkem pak vznikl komiks Vzpoura mozků, jenž se stal doslova kultem. Po více než čtyřiceti letech vyšel tento komiks v románové podobě, následně vznikla dramatizace v Českém rozhlase a nyní vychází toto kultovní dílo jako audiokniha v interpretaci Aleše Procházky.</p>
                        </div>
                        <div class="col-12 col-md-6 mt-3 text-center fs-3">
                            <span>Cena: 15$</span>
                            <div class="input-group">
                                <button id="decrement" class="btn">-</button>
                                <input type="number" id="input" value="0" class="form-control" readonly>
                                <button id="increment" class="btn">+</button>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mt-3 text-center fs-3">
                            <span>Suma: 0</span><br>
                            <a href="cart.html" role="button" class="btn btn-lg btn-success">Kupit</a>
                            <a href="#" role="button" class="btn btn-lg btn-outline-success">Pridat do košíka</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer row mx-0">
            <div class="col-4">
                Autor: Václav Šorel
            </div>
            <div class="col-4">
                Jazyk: Česky
            </div>
            <div class="col-4">
                Žánre: Fantasy a sci-fi, Česká literatúra
            </div>
        </div>
    </div>
</main>
@endsection
