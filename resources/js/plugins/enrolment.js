import Vue from 'vue';
import CripLoading from "crip-vue-loading";
import axios from 'axios';
import EnrolmentCenter from '../components/EnrolmentCenter';

Vue.use(CripLoading, {axios});

// import the styles
import 'vue-good-table/dist/vue-good-table.css'

new Vue({
    el: 'enrolment-center',
    components:{
        EnrolmentCenter
    }
});
