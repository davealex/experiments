@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <uppy-uploader
                        form-id="form-id"
                        input-id="input-id"
                        csrf-ref="csrf-token"
                        :max-size="1000000"
                    >
                        <template v-slot:info>
                            Drop files here or click to upload.
                        </template>
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
