<template>
    <vue-good-table
            :columns="columns"
            :rows="this.users"
            :search-options="{ enabled: true }"
            :pagination-options="{enabled: true}"
            :line-numbers="true">
        <template slot="table-row" slot-scope="props">
            <span v-if="props.column.field === 'name'">
                {{props.row.name}}
            </span>
            <span v-else-if="props.column.field === 'email'">
                {{props.row.email}}
            </span>
            <span v-else-if="props.column.field === 'created_at'">
                {{props.row.created_at}}
            </span>
            <span v-else-if="props.column.field === 'courses_registered'">
                <!--<span class="badge badge-pill badge-default-outline" v-for="course in props.row.courses">{{course.code}}</span>-->
            </span>
            <span v-else-if="props.column.field === 'delete'">
                <a :href="`/user/${props.row.id}/delete`"><span class="badge badge-danger">Delete</span></a>
            </span>
            <span v-else>
                {{ props.formattedRow[props.column.field] }}
            </span>
        </template>
    </vue-good-table>
</template>

<script>
    import { VueGoodTable } from 'vue-good-table';

    export default {
        props: ['users'],
        components: {
            VueGoodTable,
        },
        data(){
            return {
                columns: [
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
                    {
                        label: 'Delete',
                        field: 'delete',
                    },
                ],
            }
        },
    };
</script>