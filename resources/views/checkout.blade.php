@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <div class="col-md-6 col-md-offset-3">
            <h1>Payment Form</h1>
            <div class="spacer"></div>

            @if (session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session()->get('success_message') }}
                </div>
            @endif

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <payment-form></payment-form>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
@endsection