@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Data generator</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-{{ session('level') ?? 'info' }}" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a href="{{ route('data_generator.truncate') }}" class="btn btn-primary">{{ __('Truncate all data') }}</a>
                        <a href="{{ route('data_generator.generate_random_data') }}" class="btn btn-primary">{{ __('Generate random data') }}</a>
                        <a href="{{ route('data_generator.generate_article_test_data') }}" class="btn btn-primary">{{ __('Generate article test data') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
