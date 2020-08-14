@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">About FuSUsApp</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-{{ session('level') ?? 'info' }}" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p>Fuzzy Software Usability Application.</p>

                        <p>Author: Tomas Bodnar - bodnarto@gmail.com</p>

                        <p>&copy; 2020 MIT License</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
