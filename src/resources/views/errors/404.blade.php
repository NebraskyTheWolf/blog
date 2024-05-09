@extends('index')

@section('title', __('common.not_found'))
@section('description', __('common.not_found.description'))

@section('head')
    <style>
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;

            h1 {
                font-size: 3em;
                font-weight: bold;
                color: #dc3545;
                margin-bottom: 1em;
            }

            p {
                font-size: 1.2em;
                color: #6c757d;
                margin-bottom: 2em;
            }

            a {
                color: #ffffff;
                background-color: #007bff;
                border: none;
                padding: .375rem .75rem;
                font-size: 1rem;
                line-height: 1.5;
                border-radius: .25rem;
                text-decoration: none;
                display: inline-block;
                transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;

                &:hover {
                    color: #ffffff;
                    background-color: #0056b3;
                }
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5">
        <h1>{{ __('common.not_found') }}</h1>
        <p>{{ __('common.not_found.description') }}</p>
        <a href="{{ url('/') }}" class="btn btn-primary">{{ __('common.home') }}</a>
    </div>
@endsection
