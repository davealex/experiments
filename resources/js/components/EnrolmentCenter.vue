<template>
    <div>
        <div class="mb-3">
            <label class="typo__label">Select courses to assign</label>
            <multiselect-courses v-model="selectedCourses" :options="courses" :multiple="true"  placeholder="Search through the list of registered courses" track-by="id" label="title" :custom-label="customLabel">
                <span slot="noResult">
                    Oops! Course not found. Consider searching for another course.
                </span>
            </multiselect-courses>
            <div class="mt-3">
                <button :disabled="selectedCourses.length === 0 || selectedUsers.length === 0" @click="assign" class="btn btn-primary btn-block mb-2">Assign</button>
            </div>
        </div>
        <vue-good-table
            :columns="columns"
            :rows="learners"
            :search-options="{ enabled: true }"
            :pagination-options="{enabled: true}"
            :line-numbers="true">
            <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field === 'select'">
                    <div class="form-check">
                        <label :for="`checkbox-${props.row.id}`"></label>
                        <input :id="`checkbox-${props.row.id}`" class="form-check-input" type="checkbox" v-model="selected[props.row.id]" @change="toggleCheck(props.row.id, selected[props.row.id])">
                    </div>
                </span>
                <span v-else-if="props.column.field === 'name'">
                    {{props.row.name}}
                </span>
                <span v-else-if="props.column.field === 'email'">
                    {{props.row.email}}
                </span>
                <span v-else-if="props.column.field === 'created_at'">
                    {{props.row.created_at}}
                </span>
                <span v-else-if="props.column.field === 'courses_registered'">
                    <span v-for="({code, id}) in props.row.courses" :key="id">
                        <span class="badge badge-pill badge-success">{{code}}</span>
                    </span>
                </span>
                <span v-else>
                    {{ props.formattedRow[props.column.field] }}
                </span>
            </template>
        </vue-good-table>
    </div>
</template>

<script>
    import { VueGoodTable } from 'vue-good-table';
    import MultiselectCourses from 'vue-multiselect';
    import notify from './mixins/noty';

    export default {
        props: ['users', 'courses'],
        components: {
            VueGoodTable,
            MultiselectCourses
        },
        mixins: [notify],
        data() {
            return {
                learners: this.users,
                selected: [],
                selectedUsers: [],
                selectedCourses: [],
                columns: [
                    {
                        label: 'Select',
                        field: 'select',
                    },
                    {
                        label: 'Name',
                        field: 'name',

                    },
                    {
                        label: 'Email',
                        field: 'email',
                    },
                    {
                        label: 'Time Registered',
                        field: 'created_at',
                    },
                    {
                        label: 'Courses Registered',
                        field: 'courses_registered',
                    },
                ],
            }
        },
        computed: {
            options: function() {
                return this.courses;
            }
        },
        methods: {
            toggleCheck: function (user, status) {
                status ? this.selectedUsers.push(user) : this.selectedUsers.splice(this.selectedUsers.indexOf(user), 1);
            },
            customLabel({ title, code }) {
                return `${title} – ${code}`;
            },
            updateEnrolment({enrolled}) {
                this.learners = this.learners.map(learner => enrolled.find(({id}) => id === learner.id) || learner);

                return this;
            },
            clearSelected() {
                this.selectedCourses = [];
                this.selected = [];

                return this;
            },
            courseIds() {
                return this.selectedCourses.map(({ id }) => id);
            },
            assign() {
                axios.post('/enrol', {
                    courses: this.courseIds(),
                    users: this.selectedUsers
                })
                .then(({ data }) => {
                    this.updateEnrolment(data)
                        .clearSelected()
                        .notify('success', 'Enrolment Successful!');
                })
                .catch(err => {
                    console.error(err);
                });
            }
        }
    };
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
