<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .input{
            width: 500px;
        }
    </style>
</head>
<body>
    <div class="position-absolute top-50 start-50 translate-middle">
        <div class="rounded border border-success p-4 mb-2 border-opacity-50">
            <h4 class="fw-bold">Update Buku</h4>
            <form action="{{ route('book.update', $book->id) }}" method="POST"">
                @csrf
                @method('PUT')
                <div class="my-4">
                    <div class="d-flex flex-column input my-3">
                        <label for="title" class="form-label">Title</label>
                        <input class="form-control" type="text" name="title" value="{{ $book->title }}">
                    </div>
                    <div class="d-flex flex-column my-3">
                        <label for="creator" class="form-label">Creator</label>
                        <input class="form-control" type="text" name="creator" value="{{ $book->creator }}">
                    </div>
                    <div class="d-flex flex-column my-3">
                        <label for="price" class="form-label">Price</label>
                        <input class="form-control" type="number" name="price" value="{{ $book->price }}">
                    </div>
                    <div class="d-flex flex-column my-3">
                        <label for="publication_date" class="form-label">Publication Date</label>
                        <input class="form-control" type="date" name="publication_date" value="{{ $book->publication_date }}">
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a class="btn btn-secondary mx-2" href="{{ '/buku' }}">Kembali</a>
                    <button class="btn btn-warning" type="submit">Update</button>
                </div>
            </form>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
