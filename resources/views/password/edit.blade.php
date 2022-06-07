@extends('layouts.main')

@section('container')
<br>
<br>
<!-- Halaman untuk mengubah password -->
    <div class="container mt-4 animate__animated animate__fadeIn">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header h4">
                        Update Password
                    </div>

                    <div class="card-body">

                        @if(session('success'))
                            <div class="alert alert-success" role='alert'>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.edit') }}">
                            @method('patch')
                            @csrf

                            <!-- Input untuk password sekarang -->
                            <div class="form-group row">
                                <label for="old_password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

                                <div class="col-md-6">
                                    <input id="old-password" type="password" class="form-control" name="old_password">

                                    @error('old_password')
                                        <div class="text-danger mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Input untuk password yang baru -->
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">

                                    @error('password')
                                        <div class="text-danger mb-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Input untuk konfirmasi password terbaru -->
                            <div class="form-group row">
                                <label for="password_onfirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirm New Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary text-slate-600">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection