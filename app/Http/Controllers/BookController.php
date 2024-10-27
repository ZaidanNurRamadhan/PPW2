<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    // table pages
    public function index()
    {
        $jumlahBuku = Book::count();
        $totalPrice = Book::sum('price');
        $data_book = Book::all();
        return view('buku.index', compact('data_book', 'jumlahBuku', 'totalPrice'));
    }

    // to create book view
    public function create()
    {
        return view('buku.create');
    }

    // create book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'creator' => 'required|string|max:30',
            'price' => 'required|numeric',
            'publication_date' => 'required|date'
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->author_id = Auth::user()->id;
        $book->price = $request->price;
        $book->publication_date = $request->publication_date;
        $book->save();

        return redirect('/book')->with('created', 'Data buku berhasil dibuat');
    }

    // delete book
    public function destroy($id){
        $book = Book::find($id);
        $book->delete();

        return redirect('/book')->with('deleted', 'Data buku berhasil dihapus');
    }
    // to edit book view
    public function edit($id){
        $book = Book::find($id);
        return view('buku.edit', compact('book'));
    }
    // update book
    public function update(Request $request, $id){
        $book = Book::find($id);

        $request->validate([
            'title' => 'required|string',
            'creator' => 'required|string|max:30',
            'price' => 'required|numeric',
            'publication_date' => 'required|date'
        ]);

        $book->title = $request->title;
        $book->creator = $request->creator;
        $book->price = $request->price;
        $book->publication_date = $request->publication_date;
        $book->save();

        return redirect('/book')->with('updated', 'Data buku berhasil diperbarui');
    }
}
