@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Software Usability</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-{{ session('level') ?? 'info' }}" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('software_usability.analyze') }}" class="btn btn-primary">{{ __('Analyze') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
