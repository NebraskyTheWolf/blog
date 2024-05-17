@extends('index')
@section('title', __('common.maintenance'))
@section('description', __('common.maintenance.description'))

@section('head')
    <style>
        .maintenance-container {
            /*display: flex; */
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;

            .maintenance-image {
                max-width: 100%;
                height: auto;
                margin-bottom: 1em;
            }

            h1 {
                font-size: 3em;
                font-weight: bold;
                color: #ffc107;
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
    <div class="maintenance-container">
        <h1>{{ __('common.maintenance') }}</h1>
        <img src="{{ url('images/img.png') }}" alt="{{ __('common.maintenance') }}" class="maintenance-image">
        <p>{{ __('common.maintenance.description') }}</p>
        <a href="{{ url('/') }}" class="btn btn-primary">{{ __('common.home') }}</a>
    </div>
@endsection
