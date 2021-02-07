@extends('layouts.app')

@section('content')
    <div id="app" class="container">
        <employee-component
            id="{{ $id }}"
        >
        </employee-component>
    </div>
@endsection

