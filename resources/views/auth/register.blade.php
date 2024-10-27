@extends('layouts.layout')

@section("content")
<div class="d-flex justify-content-center align-items-center h-100">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Register</div>
            <div class="card-body">
                <form action="{{ route('store') }}" method="post" class="form p-5">
                    @csrf

                    <div class="mb-3 d-flex justify-content-between">
                        <label for="name">Name</label>
                        <div class="w-75">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-between">
                        <label for="email">Email Address</label>
                        <div class="w-75">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-between">
                        <label for="password">Password</label>
                        <div class="w-75">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-between">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="w-75">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>

                    <div class="row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Register">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

