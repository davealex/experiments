<template>
    <div>
        <h2>Profiles <span class="badge badge-pill badge-dark">{{ users.length }}</span></h2>
        <div class="row" v-if="users.length > 0">
            <div class="col-sm-4 pb-2" v-for="user in users" :key="user.id">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ user.name }}</h5>
                        <p class="card-text">{{ user.email }}</p>

                        <confirm-delete-button
                            event-call="profile-delete-called"
                            :payload="{data: user}">
                            <template v-slot:button>
                                <span class="btn btn-danger">Delete profile</span>
                            </template>
                        </confirm-delete-button>
                    </div>
                </div>
            </div>

            <confirm-delete-modal
                listening-for="profile-delete-called"
                deletion-url-prefix="/profiles"
                delete-completion-event="profile-delete-successful">
                <template v-slot:warning-message="{ model }">
                    Are you sure you want to delete <strong>{{ model.name }}</strong>'s profile?
                </template>
                <template v-slot:proceed-with-delete-button-text>
                    <span>Yes, delete this profile</span>
                </template>
            </confirm-delete-modal>
        </div>

        <div class="row" v-else>
            <div class="card">
                <div class="card-body">
                    There are no profiles yet.
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ConfirmDeleteButton from '../components/ConfirmDeleteButton';
    import ConfirmDeleteModal from '../components/ConfirmDeleteModal';

    export default {
        props: ['profiles'],
        data() {
            return {
                users: this.profiles
            }
        },
        components: {
            ConfirmDeleteButton,
            ConfirmDeleteModal
        },
        mounted() {
            this.$nextTick(() => {
                this.$root.$on('profile-delete-successful', ({model}) => {
                    this.removeDeletedProfile(model);
                })
            })
        },
        methods: {
            removeDeletedProfile(model) {
                this.users.splice(this.users.indexOf(model), 1);
            }
        }
    };
</script>
