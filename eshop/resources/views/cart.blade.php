@extends('layouts.app')

@section('content')
<main><br /><br /><br />
    <div class="container">
        <div class="row col-12">
            <div class="col col-12 col-lg-3 col-md-4 ">
                <div class="row">
                    <div class="col">
                        <div class="card align-items-center">
                            <h5 class="card-title text-center mt-3">Košík</h5>
                            <div class="card-body">
                                <nav aria-label="Pagination">
                                    <ul class="pagination pagination-sm">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">«</span>
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item active" aria-current="page">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <span aria-hidden="true">»</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="card mt-5 mb-5">
                            <div class="card-body">
                                <form>
                                    <label for="address" class="form-label">Adresa</label>
                                    <input type="text" id="address" class="form-control">

                                    <label for="delivery" class="form-label">Druh doručenia</label>
                                    <select name="delivery" id="delivery" class="form-select">
                                        <option value="1">Opcia 1</option>
                                        <option value="2">Opcia 2</option>
                                        <option value="3">Opcia 3</option>
                                    </select>

                                    <label for="payment" class="form-label">Druh platby</label>
                                    <select name="payment" id="payment" class="form-select">
                                        <option value="1">Opcia 1</option>
                                        <option value="2">Opcia 2</option>
                                        <option value="3">Opcia 3</option>
                                    </select>

                                    <label for="cost" class="form-label">
                                        <h5 class="mt-3">Celková cena</h5>
                                    </label>
                                    <input type="text" id="cost" readonly value="99999999.99€" class="form-control form-control-plaintext">
                                    <div class="row justify-content-center">
                                        <button class="btn btn-primary btn-lg mt-3">Kúpiť</button>
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
                        <div class="card mb-3">
                            <div class="row">
                                <div class="d-none d-sm-block col-3 " style="background-image: url(../img/sogun_2.jpeg); background-position-x:center;">
                                </div>
                                <div class="col-9 d-flex ">
                                    <div class="card-body flex-column">
                                        <h4 class="card-title mt-2">Autor - kniha</h4>
                                        <ul class="list-group list-group-horizontal mt-4" style="width:inherit">
                                            <li style="display:flex; flex-direction: column;" class="list-group-item justify-content-center">
                                                <p class="mb-0">Cena</p>
                                            </li>
                                            <li class="list-group-item justify-content-center" style="display:flex; flex-direction: column;">
                                                <div class="btn-group">
                                                    <button class="btn btn-secondary">-</button>
                                                    <button class="btn btn-secondary">2</button>
                                                    <button class="btn btn-secondary">+</button>
                                                </div>
                                            </li>
                                            <li style="display:flex; flex-direction: column;" class="list-group-item justify-content-center">
                                                <p class="mb-0">Celková cena</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="row">
                                <div class="d-none d-sm-block col-3 " style="background-image: url(../img/sogun_2.jpeg); background-position-x:center;">
                                </div>
                                <div class="col-9 d-flex ">
                                    <div class="card-body flex-column">
                                        <h4 class="card-title mt-2">Autor - kniha</h4>
                                        <ul class="list-group list-group-horizontal mt-4" style="width:inherit">
                                            <li style="display:flex; flex-direction: column;" class="list-group-item justify-content-center">
                                                <p class="mb-0">Cena</p>
                                            </li>
                                            <li class="list-group-item justify-content-center" style="display:flex; flex-direction: column;">
                                                <div class="btn-group">
                                                    <button class="btn btn-secondary">-</button>
                                                    <button class="btn btn-secondary">2</button>
                                                    <button class="btn btn-secondary">+</button>
                                                </div>
                                            </li>
                                            <li style="display:flex; flex-direction: column;" class="list-group-item justify-content-center">
                                                <p class="mb-0">Celková cena</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="row">
                                <div class="d-none d-sm-block col-3 " style="background-image: url(../img/sogun_2.jpeg); background-position-x:center;">
                                </div>
                                <div class="col-9 d-flex ">
                                    <div class="card-body flex-column">
                                        <h4 class="card-title mt-2">Autor - kniha</h4>
                                        <ul class="list-group list-group-horizontal mt-4" style="width:inherit">
                                            <li style="display:flex; flex-direction: column;" class="list-group-item justify-content-center">
                                                <p class="mb-0">Cena</p>
                                            </li>
                                            <li class="list-group-item justify-content-center" style="display:flex; flex-direction: column;">
                                                <div class="btn-group">
                                                    <button class="btn btn-secondary">-</button>
                                                    <button class="btn btn-secondary">2</button>
                                                    <button class="btn btn-secondary">+</button>
                                                </div>
                                            </li>
                                            <li style="display:flex; flex-direction: column;" class="list-group-item justify-content-center">
                                                <p class="mb-0">Celková cena</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
{{$cartitems}}
@endsection
