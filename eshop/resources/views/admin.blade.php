@extends('layouts.app')

@section('content')
<main class="container mt-3">
    {{$fail}}
    <div class="row">
        <div class="col-12 col-lg-2 mb-3">
            <a href="/search" role="button" class="btn btn-outline-secondary"><--- Späť</a>
        </div>
        <form method="POST" enctype="multipart/form-data" action="/admin/books/create" class="col-12 col-lg-8 fs-3">
            {{ csrf_field() }}
            <label for="book-name" class="form-label">Nazov</label>
            <input type="text" name="book-name" class="form-control" required>
            <label for="description" class="form-label">Opis</label
            <textarea name="description" class="form-control" style="height:200px" required></textarea>
            <label for="author" class="form-label">Autor</label>
            <input type="text" name="author" class="form-control" required>
            <label for="language" class="form-label">Jazyk</label>
            <select name="language" class="form-select" aria-label="language-choose" required>
                <option value="SVK">Slovensky</option>
                <option value="ENG">Anglicky</option>
            </select>
            <select class="form-select mt-3" aria-label="genres-choose" id="genres" name="genres[]" multiple required>
                @foreach ($genres as $genre)
                    <option value="{{$genre->slug}}">{{$genre->name}}</option>
                @endforeach
            </select>
            <label for="date" class="form-label">Dátum vydania</label>
            <input type="date" name="date" class="form-control" required>
            <label for="price" class="form-label">Cena</label>
            <input type="text" pattern="^(0*[1-9][0-9]?(\.[0-9]{1,2})?|0*\.[0-9]{1,2})$" name="price" class="form-control" required>
            <div class="col-lg-6 col-12 mt-3">
                <label class="form-label" for="images[]">Obrazky</label>
                <input accept=".jpeg,.jpg,.png" placeholder="Vyberte aspoň 2 obrázky." class="btw btn-primary" type="file" name="images[]" multiple id="images">
                <label for="images" class="form-label mt-1">Vyberte aspoň 2 obrázky</label>
                <div id="error-message" class="text-danger mt-1"></div>
            </div>
            <button type="submit" class="btn btn-success" id="submit-button" disabled>Uložiť</button>
        </form>
    </div>
    <script>
    document.getElementById('images').addEventListener('change', function() {
      const files = this.files;
      if (files.length < 2) {
        document.getElementById('error-message').innerText = 'Please select at least 2 images.';
        document.getElementById('submit-button').disabled = true;
      } else {
        document.getElementById('error-message').innerText = '';
        document.getElementById('submit-button').disabled = false;
      }
    });
    </script>
</main>
@endsection
