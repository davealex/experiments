import Vue from 'vue';
// import VueGoodTablePlugin from 'vue-good-table';
// import { VueGoodTable } from 'vue-good-table';
import UsersList from '../components/UsersList';

// import the styles
import 'vue-good-table/dist/vue-good-table.css'

// Vue.use(VueGoodTable);

new Vue({
    el: 'users-list',
    components:{
        UsersList
    }
});
