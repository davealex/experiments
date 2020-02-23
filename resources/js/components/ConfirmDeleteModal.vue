<template>
    <div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" ref="deleteDialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="model" class="modal-title">
                        <slot name="warning-message" :model="model">Warning</slot>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button v-if="model" :disabled="disabled" class="btn btn-danger" @click="executeDeletion">
                        <slot name="proceed-with-delete-button-text">Are you sure?</slot>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import notify from './mixins/noty';

    export default {
        props: ['listeningFor', 'deletionUrlPrefix', 'deleteCompletionEvent'],
        data() {
            return {
                model: null,
                disabled: true
            }
        },
        mounted() {
            this.$root.$on(this.listeningFor, ({data}) => {
                this.updateModel(data)
                    .openConfirmDialogModal();

                this.disabled = false;
            })
        },
        mixins: [notify],
        methods: {
            updateModel(data) {
                this.model = data;

                return this;
            },
            openConfirmDialogModal() {
                $(this.$refs.deleteDialog).modal();
            },
            executeDeletion() {
                if (this.model) {
                    this.disabled = true;
                    axios.delete(`${this.deletionUrlPrefix}/${this.model.id}/delete`)
                        .then(({ data }) => {
                            this.closeConfirmDialogModal()
                                .broadcastProfileDeletion()
                                .clearModelProp()
                                .notify('success', data.message)
                            ;
                        })
                        .catch(err => {
                            console.error(err);

                            this.disabled = false;
                        });
                } else this.notify('warning', 'Please select a profile first.');
            },
            broadcastProfileDeletion() {
                this.$root.$emit(this.deleteCompletionEvent, {model: this.model});

                return this;
            },
            closeConfirmDialogModal() {
                $(this.$refs.deleteDialog).modal('hide');

                return this;
            },
            clearModelProp() {
                this.model = null;

                return this;
            }
        }
    };
</script>
