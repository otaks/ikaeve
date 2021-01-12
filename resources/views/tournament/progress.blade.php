@extends('layouts.app')

@section('content')
        <div class="card-body">
            <div class="container-fluid">
              @include('tournament/nav')
              <table class="table table-bordered table-hover mt-3" style="table-layout:fixed;">
                  <tr class="table-info">
                    <th class="text-center p-1" rowspan="2" style="width:50px;"></th>
                    <th class="text-center p-1 align-middle" rowspan="2" style="width:50px;">確定</th>
                    <th class="text-center p-1" colspan="2" style="width:80px;">第1試合</th>
                    <th class="text-center p-1" colspan="2" style="width:80px;">第2試合</th>
                    <th class="text-center p-1" colspan="2" style="width:80px;">第3試合</th>
                  </tr>
                  <tr class="table-info">
                    <th class="text-center p-1">1-2</th>
                    <th class="text-center p-1">3-4</th>
                    <th class="text-center p-1">1-2</th>
                    <th class="text-center p-1">3-4</th>
                    <th class="text-center p-1">1-2</th>
                    <th class="text-center p-1">3-4</th>
                  </tr>
                  @foreach ($sheets as $sheet)
                    <tr>
                      <th class="text-center p-1">{{ $sheet->sheet }}</th>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  @endforeach
              </table>
          </div>
      </div>
@endsection
