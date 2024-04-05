{{-- Filter form component --}}
<form class="row my-3" action="{{ $action }}" method="GET">
      <div class="col-6 my-lg-3 my-1">
        <label for="price-from" class="form-label">Od</label>
        <input type="number" name="price-from" class="form-control border border-secondary" id="price-from" placeholder="10" value="{{request('priceFrom')}}">
      </div>
      <div class="col-6 my-lg-3 my-1">
        <label for="price-to"class="form-label">Do</label>
        <input type="number" name="price-to" class="form-control border border-secondary" id="price-to" placeholder="1000" value="{{request('priceTo')}}">
      </div>
      <div class="col-12 my-lg-3 my-1">
        <label for="date" class="form-label">Dátum od</label>
        <input type="date" name="date" class="form-control border border-secondary" id="date" placeholder="10.03.2023" value="{{request('dateFrom')}}">
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
