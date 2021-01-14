@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
              @if ($isMobile)
                @include('tournament/nav_sp')
                @include('tournament/table_sp')
              @else
                @include('tournament/nav')
                @include('tournament/table')
            @endif
            </div>
        </div>
@endsection
