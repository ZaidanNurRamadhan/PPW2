@extends('layouts.layout')

@section('content')
<div class="d-flex justify-content-center align-items-center h-100">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info fs-2">Login</div>
            <div class="card-body">
                <form action="{{ route('authenticate') }}" method="post" class="form p-5">
                    @csrf
                    <div class="mb-3 d-flex justify-content-between">
                        <label class="fs-5" for="email">Email Address</label>
                        <div class="w-75">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-between">
                        <label class="fs-5" for="password">Password</label>
                        <div class="w-75">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-5">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary fs-3" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
