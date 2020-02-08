@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <enrolment-center
                            :users="{{ $users }}"
                            :courses="{{ $courses }}">
                        </enrolment-center>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/plugins/enrolment.js"></script>
@endsection
