import Vue from 'vue';
import CripLoading from "crip-vue-loading";
import axios from 'axios';
import EnrolmentCenter from '../components/EnrolmentCenter';

import 'vue-good-table/dist/vue-good-table.css'

Vue.use(CripLoading, {axios});

new Vue({
    el: 'enrolment-center',
    components:{
        EnrolmentCenter
    }
});
