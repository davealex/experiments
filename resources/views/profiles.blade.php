@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <user-profiles
                   :profiles="{{ $profiles }}">
                </user-profiles>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/plugins/user_profiles.js "></script>
@endsection
