@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Software Usability - analyze</div>

                <div class="card-body" style="background-color:black;">
                    @if (session('status'))
                        <div class="alert alert-{{ session('level') ?? 'info' }}" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {!! $command_output !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
