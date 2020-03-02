<template>
    <form>
        <div class="image-container mb-3" v-if="previewPath">
            <img :src="previewPath" alt="Uploaded Image Preview">
        </div>
        <div class="form-group">
            <div ref="dashboardContainer"></div>
        </div>
        <button :disabled="disabled" @click.prevent="confirmUpload" class="btn btn-primary btn-block mb-2">Confirm upload</button>
    </form>
</template>

<script>
    import Uppy from '@uppy/core';
    import XHRUpload from '@uppy/xhr-upload';
    import Dashboard from '@uppy/dashboard';
    import Form from '@uppy/form';

    import notify from './mixins/noty';

    import '@uppy/core/dist/style.css';
    import '@uppy/dashboard/dist/style.css';

    export default {
        props: {
            maxFileSizeInBytes: {
                type: Number,
                required: true
            }
        },
        mixins: [notify],
        data() {
            return {
                payload: null,
                previewPath: null,
                disabled: true
            }
        },
        mounted() {
            this.instantiateUppy()
        },
        methods: {
            instantiateUppy() {
                this.uppy = Uppy({
                    debug: true,
                    autoProceed: true,
                    restrictions: {
                        maxFileSize: this.maxFileSizeInBytes,
                        minNumberOfFiles: 1,
                        maxNumberOfFiles: 1,
                        allowedFileTypes: ['image/*', 'video/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf']
                    }
                })
                    .use(Dashboard, {
                        hideUploadButton: true,
                        inline: true,
                        height: 450,
                        target: this.$refs.dashboardContainer,
                        replaceTargetContent: true,
                        showProgressDetails: true,
                        browserBackButtonClose: true

                    })
                    .use(XHRUpload, {
                        limit: 10,
                        endpoint: '/file/upload',
                        formData: true,
                        fieldName: 'file',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // from <meta name="csrf-token" content="{{ csrf_token() }}">
                        }
                    });

                this.uppy.on('complete', (event) => {
                    if(event.successful[0] !== undefined) {
                        this.payload = event.successful[0].response.body.path;

                        this.disabled = false;
                    }
                });
            },
            updatePreviewPath({path}) {
                this.previewPath = path;

                return this;
            },
            resetUploader() {
                this.uppy.reset();
                this.disabled = true;

                return this;
            },
            confirmUpload() {
                if(this.payload) {
                    this.disabled = true;
                    axios.post('/store', { file: this.payload })
                        .then(({ data }) => {
                            this.updatePreviewPath(data)
                                .resetUploader()
                                .notify('success', 'Upload Successful!');
                        })
                        .catch(err => {
                            console.error(err);

                            this.resetUploader();
                        })
                    ;
                } else notify('warning', `You don't have any file in processing`);

            }
        }
    };
</script>

<style scoped>
    .image-container {
        height: 150px;
        width: 150px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: auto;
        margin-left: auto;
    }

    .image-container > img {
        width: inherit;
        height: inherit;
    }
</style>
