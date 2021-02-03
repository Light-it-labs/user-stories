import Vue from 'vue';
import router from './routes';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { ValidationObserver, ValidationProvider, extend, localize } from 'vee-validate';
import { setInteractionMode } from 'vee-validate';
import en from 'vee-validate/dist/locale/en.json';
import * as rules from 'vee-validate/dist/rules';
import UserAuthForm from './components/UserAuthForm.vue';
import ForgotPassword from './components/ForgotPassword.vue';
import InviteUserForm from './components/InviteUserForm.vue';
import ProjectForm from './components/ProjectForm.vue';
import ProjectIndex from './components/ProjectIndex.vue';
import Project from './components/Project.vue';
import NavBar from './components/NavBar.vue';



const {default: Axios} = require('axios');

require('./bootstrap');


window.Vue = require('vue');

Vue.config.devtools = true;

Vue.use(VueToast, {
    position: "bottom"
});

Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});
  
localize('en', en);



setInteractionMode('aggressive');

Vue.component('VueToast', require('vue-toast-notification').default);
Vue.component('ValidationObserver', ValidationObserver).default;
Vue.component('ValidationProvider', ValidationProvider).default;

const app = new Vue({
    el: '#app',

    router,
    
    data(){
        return{

        }
    },

    components:{NavBar, UserAuthForm, ForgotPassword, ProjectForm, ProjectIndex, InviteUserForm, Project},

    created(){
        const user = JSON.parse(localStorage.getItem("user"));
        const acces_token = JSON.parse(localStorage.getItem("access_token"));

        if(user && acces_token){
            axios.defaults.headers.common.Authorization = `Bearer ${acces_token}`;
        }
    }

});
