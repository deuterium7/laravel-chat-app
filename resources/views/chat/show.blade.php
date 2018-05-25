@extends('layouts.app')

@section('content')
    <div class="container">
        <chat-item :id="'{!! json_encode($id) !!}'"></chat-item>
    </div>
@endsection
