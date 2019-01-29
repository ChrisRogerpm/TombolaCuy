@extends('Shared.layout')

@section('content')
{{Auth::user()->usuario}}
@endsection