@extends('layouts.layout')

@section('content')
    <section class="d-flex justify-content-center flex-column align-items-center h-100">
        @if ($user->photo)
        <img src="{{ asset('storage/' . $user->photo)}}" alt="" width="300px" class="rounded" style="border-radius: 50%">
        @else
            <p>No photo available</p>
        @endif
        <a href="">Edit</a>
        <p>{{ $user->name }}</p>
        <p>{{ $user->email }}</p>
    </section>
@endsection
