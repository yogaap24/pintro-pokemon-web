<!DOCTYPE html>
<html>
<head>
    <title>Pokemons</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">   
</head>
<body>
    <div class="container mt-5">
        <h1>List of Pokemons</h1>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="GET" action="{{ route('home') }}" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="limit" class="form-label">Limit</label>
                    <select id="limit" name="limit" class="form-select" onchange="this.form.submit()">
                        @foreach([10, 20, 30, 50, 70, 100] as $option)
                            <option value="{{ $option }}" {{ $option == $limit ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="offset" class="form-label">Offset</label>
                    <select id="offset" name="offset" class="form-select" onchange="this.form.submit()">
                        @foreach([0, 10, 20, 30, 40, 50] as $option)
                            <option value="{{ $option }}" {{ $option == $offset ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <div class="row">
            @foreach($pokemons as $pokemon)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $pokemon['name'] }}</h5>
                            {{-- <a href="{{ route('catch.pokemon', ['id' => $pokemon['id']]) }}" class="btn btn-primary">Catch</a> --}}
                            <a href="{{ route('showbyid', ['id' => $pokemon['id']]) }}" class="btn btn-primary">Detail by ID</a>
                            <a href="{{ route('showbyname', ['name' => $pokemon['name']]) }}" class="btn btn-secondary">Detail by Name</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination">
                @if($currentPage > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ route('home', ['limit' => $limit, 'offset' => max(0, $offset - $limit)]) }}">Previous</a>
                    </li>
                @endif
                @if($currentPage < $lastPage)
                    <li class="page-item">
                        <a class="page-link" href="{{ route('home', ['limit' => $limit, 'offset' => $offset + $limit]) }}">Next</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
