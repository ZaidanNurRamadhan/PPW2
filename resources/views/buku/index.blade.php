@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

<div class="mt-5 container">
    <h1>Daftar Buku</h1>

    @if(Session::has('created'))
        <div class="modal fade" id="createdModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ Session::get('created') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(Session::has('updated'))
        <div class="modal fade" id="createdModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ Session::get('updated') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(Session::has('deleted'))
        <div class="modal fade" id="createdModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ Session::get('deleted') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(Session::has('login'))
        <div class="modal fade" id="createdModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ Session::get('login') }}</p>
                        <p class="fw-semibold"> Hello {{ Auth::user()->name }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(Session::has('logout'))
    <div class="modal fade" id="createdModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ Session::get('logout') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    <table class="datatable align-middle table table-light table-striped text-center">
        <thead>
            <tr class="table-primary">
                <th>Number</th>
                <th>ID</th>
                <th>Book's Title</th>
                <th>Creator</th>
                <th>Price</th>
                <th>Publication Date</th>
                @auth
                <th>Update</th>
                <th>Hapus</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @foreach ($data_book as $index => $book)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $book->id }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author->name }}</td>
                    <td>{{ "Rp. " . number_format($book->price, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($book->publication_date)->format('d-m-Y') }}</td>
                    @auth
                    <td>
                        <a class="btn btn-primary" href="{{ route('book.edit', $book->id) }}">Update</a>
                    </td>
                    <td>
                        <form action="{{ route('book.destroy', $book->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('yakin mau hapus?')" type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                    @endauth
                </tr>
            @endforeach
        </tbody>
    </table>
    @auth
    <div class="d-flex justify-content-end">
        <a href="{{ route('book.create') }}" class="btn btn-primary">Tambah Buku</a>
    </div>
    @endauth
    <div class="d-flex gap-4">
    <h6>Jumlah Buku : {{ $jumlahBuku }}</h6>
    <h6>Total Harga : {{"Rp. " . number_format($totalPrice, 2, ',', '.') }}</h6>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script>
    new DataTable('.datatable');
</script>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var createdModal = new bootstrap.Modal(document.getElementById('createdModal'));
        createdModal.show();
    });
</script>
