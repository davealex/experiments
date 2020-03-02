@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <uppy-uploader
                            :max-file-size-in-bytes="1000000">
                    </uppy-uploader>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="/js/plugins/uppy_uploader.js"></script>
@endsection
