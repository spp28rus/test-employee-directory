@extends('layouts.app')

@section('content')
    <div id="app" class="container">
        @guest
            <employees-table-component
                par-only-public-info=true
                par-there-is-admin-role=false
            >
            </employees-table-component>
        @else
            @if ($is_admin)
                <div id="head-admin-links">
                    <b-row>
                        <b-col class="text-center">
                            <b-button href="{{ @route('posts') }}">Posts</b-button>
                            <b-button href="{{ @route('skills') }}">Skills</b-button>
                        </b-col>
                    </b-row>
                </div>
            @endif
            <employees-table-component
                par-only-public-info=false
                par-there-is-admin-role="{{ $is_admin }}"
            >
            </employees-table-component>
        @endguest
    </div>
@endsection

