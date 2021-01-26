<template>
  <div class="min-h-screen flex flex-col py-2 sm:px-2 lg:px-8">

    <div v-if="!hasToken" class="w-full pt-6 mb-2 flex justify-center items-center relative">
      <BackButton></BackButton>
      <h2 class="m-0 text-center text-3xl font-extrabold text-gray-600">Forgot Your Password?</h2>
    </div>
    
    <div class="mt-8 sm:w-full bg-white shadow sm:rounded-lg">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <ValidationObserver v-slot="{ handleSubmit }">
          <form
            class="space-y-6"
            action=""
            method="POST"
            @submit.prevent="handleSubmit(checkForm)"
          >
          

            <div v-if="!hasToken">
              
              <p class="mt-2 font-medium text-center text-sm text-gray-700 max-w">
                Just enter your email address below and we'll send you a link to reset your password!
              </p>
            </div>

            <div v-else>
              <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-600">
                Reset Password
              </h2>
              <p class="mt-2 font-medium text-center text-sm text-gray-700 max-w">              
                Just enter your new password!
              </p>
            </div>

            <div v-if="!hasToken">
              <ValidationProvider name="Email" rules="required|email" v-slot="{errors}">
                <label for="email" class="block text-sm font-medium text-gray-700">
                  Email address
                </label>
                <div class="mt-1">
                  <input
                    id="email"
                    name="email"
                    type="email"
                    v-model="userInfo.email"
                    autocomplete="email"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  />
                </div>
                <div v-if="errors[0]" class="mt-2">
                    <span class="error-text">{{errors[0]}}</span>
                </div>
              </ValidationProvider>
            </div>

            <div v-if="hasToken">
              <ValidationProvider name="Password" rules="required" v-slot="{errors}" vid="confirmation">
                <label
                  for="password"
                  class="block text-sm font-medium text-gray-700"
                >
                  Password
                </label>
                <div class="mt-1">
                  <input
                    id="password"
                    name="password"
                    type="password"
                    v-model="userInfo.password"
                    autocomplete="current-password"
                    
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  />
                </div>
                <div v-if="errors[0]" class="mt-2">
                      <span class="error-text">{{errors[0]}}</span>
                </div>
              </ValidationProvider>
            </div>

            <div v-if="hasToken">
              <ValidationProvider name="Confirm-Password" rules="required|confirmed:confirmation" v-slot="{errors}">
                <label
                  for="rePassword"
                  class="block text-sm font-medium text-gray-700"
                >
                  Confirm Password
                </label>
                <div class="mt-1">
                  <input
                    id="rePassword"
                    name="rePassword"
                    type="password"
                    v-model="rePassword"
                    autocomplete="re-password"
                    
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  />
                </div>
                <div v-if="errors[0]" class="mt-2">
                      <span class="error-text">{{errors[0]}}</span>
                </div>
              </ValidationProvider>
            </div>

            <div>
              <button
                type="submit"
                class="basicButton w-full flex justify-center"
              >
                {{buttonText}}
              </button>
            </div>
          </form>
        </ValidationObserver>
      </div>
    </div>
  </div>
</template>

<script>
import BackButton from './BackButton.vue';

  export default {
    data(){
      return{
        userInfo:{
          email: this.$route.query.email,
          password: "",
          token: this.$route.query.token,
        },

        rePassword: "",
      }
    },

    components:{BackButton},

    props: ["buttonText", "hasToken"],

    methods:{

      async sentResetLinkPassword(){
        try{
          const response = await axios.post('/api/auth/password/email', this.userInfo);

          if(response.status === 200 && response.data.success === true){
            Vue.$toast.success(response.data.message);
          }

        }catch(e){
          Vue.$toast.error(e);
        }
      },

       async resetPassword() {
        try{
          const response = await axios.post('api/auth/password/reset', this.userInfo)

          if(response.status === 200 && response.data.success === true){
            Vue.$toast.success(response.data.message);
            window.location.href = '/';
          }

        }catch(e){
          Vue.$toast.error(e);
        }
      },

      checkForm: function(e){
        
        if(!this.hasToken){
          this.sentResetLinkPassword();
        }else{
          this.resetPassword();
        }
        
        return true;
        
        e.preventDefault();
      }
    }
  }
</script>

<style scoped>

</style>