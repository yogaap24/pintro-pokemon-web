<!DOCTYPE html>
<html>
<head>
    <title>Pokemons</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>List of Pokemons</h1>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="row">
            @foreach($pokemons as $pokemon)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $pokemon['name'] }}</h5>
                            <a href="{{ route('catch.pokemon', ['id' => $pokemon['id']]) }}" class="btn btn-primary">Catch</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination">
                @if($currentPage > 1)
                    <li class="page-item"><a class="page-link" href="{{ route('home', ['limit' => $limit, 'offset' => max(0, $offset - $limit)]) }}">Previous</a></li>
                @endif
                @if($currentPage < $lastPage)
                    <li class="page-item"><a class="page-link" href="{{ route('home', ['limit' => $limit, 'offset' => $offset + $limit]) }}">Next</a></li>
                @endif
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
