@extends('layouts.app')

@section('content')
    <div id="app" class="container">
        <simple-title-table-component
            url="{{ $url }}"
            title="{{ $title }}"
        >
        </simple-title-table-component>
    </div>
@endsection

