@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('content')
<div class="container">
  <h1>{{ trans('logDetails') }}</h1>
  <table class="table">
      <tr>
          <th>ID</th>
          <td>{{ $log->id }}</td>
      </tr>
      <tr>
          <th>User ID</th>
          <td>{{ $log->user_id }}</td>
      </tr>
      <tr>
          <th>Action</th>
          <td>{{ $log->action }}</td>
      </tr>
      <tr>
          <th>Details</th>
          <td><pre>{{ json_encode(json_decode($log->details), JSON_PRETTY_PRINT) }}</pre></td>
      </tr>
      <tr>
          <th>Timestamp</th>
          <td>{{ $log->created_at }}</td>
      </tr>
  </table>
  <a href="{{ $log->action == "access" ? route('administration.log.log-access') : route('administration.log.log-actions') }}" class="btn btn-primary">Back to Logs</a>
</div>
@endsection
