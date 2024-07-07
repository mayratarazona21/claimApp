@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('content')
<div class="container">
  <h1>{{ trans('logDetails') }}</h1>
  <table class="table">
      <tr>
          <th>{{ trans('user') }}</th>
          <td>{{ $log->first_name }}</td>
      </tr>
      <tr>
          <th>{{ trans('action') }}</th>
          <td>{{ $log->action }}</td>
      </tr>
      <tr>
        <th>{{ trans('description') }}</th>
        <td>{{ $log->description }}</td>
    </tr>
      <tr>
          <th>{{ trans('details') }}</th>
          <td><pre>{{ json_encode(json_decode($log->details), JSON_PRETTY_PRINT) }}</pre></td>
      </tr>
      <tr>
          <th>{{ trans('timestamp') }}</th>
          <td>{{ $log->created_at }}</td>
      </tr>
  </table>
  <a href="{{ $log->action == "access" ? route('administration.log.log-access') : route('administration.log.log-actions') }}" class="btn btn-primary">Back to Logs</a>
</div>
@endsection
