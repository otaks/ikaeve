@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
              @include('elements.flash_message')
              @if ($isMobile)
                @include('tournament/nav_sp')
                @include('tournament/table')
              @else
                @include('tournament/nav')
                @include('tournament/table')
            @endif
            </div>
        </div>
        <script src="{{ asset('/js/reload.js') }}"></script>
@endsection
