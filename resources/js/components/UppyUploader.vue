<template>
    <form :id="formId">
        <div class="mb-3 d-flex" v-if="paths.length !== 0">
            <div class="image-container" v-for="(path, index) in paths" :key="index">
                <img :src="path" :alt="`Uploaded Image-${index}`">
            </div>
        </div>
        <div class="form-group">
            <div class="DashboardContainer">
                <div class="UppyModalOpenerBtn">
                    <i class="fa fa-file-o fa-5x" aria-hidden="true"></i>
                    <div class="dz-message needsclick">
                        <span class="dz-message-header">
                            <slot name="info"></slot>
                        </span>
                        <span class="dz-message-description">(Selected files are <strong>uploaded</strong> automatically.)</span>
                    </div>
                </div>
            </div>
        </div>
        <button :disabled="disabled" @click.prevent="confirmUpload" class="btn btn-primary btn-block mb-2">Confirm upload</button>
    </form>
</template>

<script>
    import Uppy from '@uppy/core';
    import XHRUpload from '@uppy/xhr-upload';
    import Dashboard from '@uppy/dashboard';
    import Form from '@uppy/form';
    import axios from 'axios';
    import notify from './mixins/noty';

    import '@uppy/core/dist/style.css';
    import '@uppy/dashboard/dist/style.css';

    export default {
        props: {
            formId: {
                type: String,
                required: true
            },
            inputId: {
                type: String,
                required: true
            },
            csrfRef: {
                type: String,
                required: true
            },
            maxSize: {
                type: Number,
                required: true
            }
        },
        mixins: [notify],
        data() {
            return {
                payload: [],
                paths: [],
                disabled: false
            }
        },
        mounted() {
            this.$nextTick(() => {
                this.uppy = Uppy({
                    debug: true,
                    autoProceed: true,
                    restrictions: {
                        maxFileSize: this.maxSize,
                        minNumberOfFiles: 1,
                        maxNumberOfFiles: 3,
                        allowedFileTypes: ['image/*', 'video/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf']
                    }
                })
                .use(Dashboard, {
                    trigger: '.UppyModalOpenerBtn',
                    hideUploadButton: true,
                    inline: true,
                    height: 450,
                    target: '.DashboardContainer',
                    replaceTargetContent: true,
                    showProgressDetails: true,
                    note: '1 file only (up to 1 MB)',
                    browserBackButtonClose: true

                })
                .use(XHRUpload, {
                    limit: 10,
                    endpoint: '/file/upload',
                    formData: true,
                    fieldName: 'file',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector(`meta[name="${this.csrfRef}"]`).getAttribute('content')
                    }
                });

                this.uppy.on('complete', (event) => {
                    console.log(event.successful);
                    if(event.successful.length !== 0) {
                        event.successful.forEach(this.addPayload);
                    }
                    console.log(JSON.stringify(this.payload));
                });
            });
        },
        methods: {
            addPayload(item, index, array) {
                array[index] !== undefined && this.payload.push(item.response.body.path);
            },
            confirmUpload() {
                if(this.payload.length !== 0) {
                    this.disabled = true;
                    axios.post('/store', { files: JSON.stringify(this.payload) })
                        .then(({data}) => {
                            console.log(data.paths);
                            this.paths = data.paths;
                            this.notify('success', 'Upload Successful!');
                            this.uppy.reset();
                            this.disabled = false;
                            this.payload = [];
                        })
                        .catch(response => {
                            console.error(response.toJSON());
                            this.disabled = false;
                        })
                    ;
                } else {
                    this.notify('error', 'Opops...No Uploaded file(s)');
                }

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
        padding: 5px;
    }

    .image-container > img {
        width: inherit;
        height: inherit;
    }
</style>