@if($genres->isNotEmpty())
    <ul>
        <li><a href={{ route('books.genre', ['Genre' => 'all']) }}>Všetky žánre</a></li>
        @foreach($genres as $genre)
            <li><a href={{ route('books.genre', ['Genre' => $genre->slug]) }}>{{ $genre->name }}</a></li>
            <!-- Add your action link or button here -->
        @endforeach
    </ul>
@endif
