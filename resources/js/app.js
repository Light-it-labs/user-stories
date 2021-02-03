import Vue from 'vue';
import router from './routes';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { ValidationObserver, ValidationProvider, extend, localize } from 'vee-validate';
import en from 'vee-validate/dist/locale/en.json';
import * as rules from 'vee-validate/dist/rules';
import UserAuthForm from './components/UserAuthForm.vue';
import ForgotPassword from './components/ForgotPassword.vue';
import InviteUserForm from './components/InviteUserForm.vue';
import ProjectForm from './components/ProjectForm.vue';
import ProjectIndex from './components/ProjectIndex.vue';
import Project from './components/Project.vue';
import VOffline from 'v-offline';


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

Vue.component('VueToast', require('vue-toast-notification').default);
Vue.component('ValidationObserver', ValidationObserver).default;
Vue.component('ValidationProvider', ValidationProvider).default;

const app = new Vue({
    el: '#app',

    router,
    
    data(){
        return{
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
        }
    },

    components:{UserAuthForm, ForgotPassword, ProjectForm, ProjectIndex, InviteUserForm, Project, VOffline},

    methods:{
        amIOnline(e){
            if(this.onLine != null){
              if(e === false){
                Vue.$toast.error('Lost connection!');
              }else{
                Vue.$toast.success('Connected!');
                this.$router.go();
              }
            }
            this.onLine = e;
          },
    }

});
