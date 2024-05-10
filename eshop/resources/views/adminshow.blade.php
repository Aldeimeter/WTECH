@extends('layouts.app')

@section('content')
<main class="container mt-3">
    <div class="row">
        <div class="col-12 col-lg-2 mb-3">
            <a href="#" role="button" class="btn btn-outline-secondary"><--- Späť</a>
        </div>
        <form method="POST" enctype="multipart/form-data" action="/books/update/{{$book->id}}" class="col-12 col-lg-8 fs-3">
            {{ csrf_field() }}
            {{method_field("PUT")}}
            <label for="book-name" class="form-label">Nazov</label>
            <input type="text" name="book-name" class="form-control" required value="{{$book->name}}">
            <label for="description" class="form-label">Opis</label>
            <textarea name="description" class="form-control" style="height:200px" required>{{$book->description}}</textarea>
            <label for="author" class="form-label">Autor</label>
            <input type="text" name="author" class="form-control" required value="{{$author->fullname}}">
            <label for="language" class="form-label">Jazyk</label>
            <select name="language" class="form-select" aria-label="language-choose" required>
                <option value="SVK"
                    @if($book->language === "SVK")
                        selected
                    @endif
                >Slovensky</option>
                <option value="ENG"
                    @if($book->language === "SVK")
                        selected
                    @endif
                >Anglicky</option>
            </select>
            <select class="form-select mt-3" aria-label="genres-choose" id="genres" name="genres[]" multiple required>
                @foreach ($genresIncluded as $genre)
                    <option selected value="{{$genre->slug}}">{{$genre->name}}</option>
                @endforeach
                @foreach ($genresExcluded as $genre)
                    <option value="{{$genre->slug}}">{{$genre->name}}</option>
                @endforeach
            </select>
            <label for="date" class="form-label">Dátum vydania</label>
            <input type="date" name="date" class="form-control" required value="{{date_format($book->publish_date, "Y-m-d")}}">
            <label for="price" class="form-label">Cena</label>
            <input type="text" pattern="[0-9]{2}.[0-9]{2}" name="price" class="form-control" required value="{{$book->price}}">
            <div class="col-lg-6 col-12 mt-3">
                <label class="form-label" for="images[]">Pridať Nové Obrazky</label>
                <input accept=".jpeg,.jpg,.png" class="btw btn-primary" type="file" name="images[]" multiple>
            </div>
            <button type="submit" class="btn btn-success">Uložiť</button>
            <button type="submit" class="btn btn-danger" formaction="/books/delete/{{$book->id}}">Vymazať</button>
        </form>
    </div>
</main>
@endsection
