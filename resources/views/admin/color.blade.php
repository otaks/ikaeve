@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
              @include('admin/nav')
              @include('elements.flash_message')
              <form method="POST">
                  @csrf
                    <div class="form-group row mt-5">
                  @foreach ($sheets as $k => $sheet)
                          <label for="name" class="col-md-1 col-1 col-form-label text-md-right mb-2">{{ $sheet }}</label>
                          <div class="col-md-1 col-1">
                              <input type="color" class="form-control" name="color[]"
                              value="{{ $colors[$sheet] ?? 'ffffff'}}">
                              <input type="hidden" name="sheet[]" value="{{ $sheet }}">
                          </div>
                  @endforeach
                  </div>
                  <div class="form-group row mt-5">
                      <div class="col-md-6 offset-md-3 col-12 text-center">
                          <button type="submit" class="btn btn-primary submit w-25">編集</button>
                     </div>
                  </div>
              </form>
            </div>
        </div>
@endsection
