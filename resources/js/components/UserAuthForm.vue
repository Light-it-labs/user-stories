<template>
  <div class="min-h-screen flex flex-col py-2 sm:px-2 lg:px-8">
    
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
    <img 
      class="mx-auto h-12 w-auto" 
      src="/storage/logos/lightit-logo.png" 
      alt="LightIt-Logo">
    <div v-if="isSignup" class="w-full pt-6 mb-2 flex justify-center items-center relative">
      <h2 class="m-0 text-center text-3xl font-extrabold text-gray-900">Sign Up</h2>
    </div>
    <div v-else class="w-full pt-6 mb-2 flex justify-center items-center relative">
      <h2 class="m-0 text-center text-3xl font-extrabold text-gray-900">Log In</h2>
    </div>
  </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <ValidationObserver v-slot="{ handleSubmit }">
          <form
            class="space-y-6"
            action=""
            method="post"
            @submit.prevent="handleSubmit(checkForm)"
          >
            <div v-if="isSignup">
              <ValidationProvider name="Name" rules="required" v-slot="{errors}">
                <label for="name" class="block text-sm font-medium text-gray-700">
                  Name
                </label>
                <div class="mt-1">
                  <input
                    id="name"
                    name="name"
                    type="text"
                    v-model="userInfo.name"
                    autocomplete="name"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  />
                </div>
                <div v-if="errors[0]" class="mt-2">
                    <span class="error-text">{{errors[0]}}</span>
                </div>
              </ValidationProvider>
            </div>

            <div>
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

            <div v-if="isSignup">
              <ValidationProvider name="Image" rules="image" v-slot="{errors}">
                <label for="image" class="block text-sm font-medium text-gray-700">
                  Profile image
                </label>
                <div class="mt-1">
                  <input
                    id="image"
                    name="image"
                    type="file"
                    v-on:change="setFile($event.target.files)"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  />
                </div>
                <div v-if="errors[0]" class="mt-2">
                    <span class="error-text">{{errors[0]}}</span>
                </div>
              </ValidationProvider>
            </div>

            <div>
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

            <div v-if="isSignup">
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

            <div v-if="!isSignup" class="flex items-center justify-between">
              <div class="flex items-center">
                <input
                  id="remember_me"
                  name="remember_me"
                  type="checkbox"
                  v-model="userInfo.remember_me"
                  class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                />
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                  Remember me
                </label>
              </div>

              <div class="text-sm">
                <a
                  href="/password/reset"
                  class="font-medium text-indigo-600 hover:text-indigo-500"
                >
                  Forgot your password?
                </a>
              </div>
            </div>

            <div>
              <button
                type="submit"
                class="basicButton w-full flex justify-center"
              >
                {{ buttonText }}
              </button>
            </div>
          </form>
        </ValidationObserver>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      userInfo: {
        name: "",
        email: "",
        password: "",
        image: null,
        remember_me: false
      },

      rePassword: "",
    };
  },

  props: ["buttonText", "isSignup"],

  methods: {

    getBase64(file) {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
      });
    },

    setFile([file]){
      this.getBase64(file).then(data => this.userInfo.image = data);
    },

    async signUp(){
      try{
        const response = await axios.post('api/auth/signup',this.userInfo);
        Vue.$toast.success(response.data.message);
        window.location.href = '/';

      }catch(e){
        Vue.$toast.error(e);
      }
      
    },

    async logIn(){
      try{
        const response = await axios.post('api/auth/login', this.userInfo);
        
        if(response.status === 200 && response.data.success === true){
          Vue.$toast.success("Successfully authenticated");
          localStorage.setItem('user', JSON.stringify(response.data.user));
          localStorage.setItem('access_token', JSON.stringify(response.data.access_token));
          axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.access_token}`;
          window.location.href = '/projects';
        }

      }catch(e){
        Vue.$toast.error(e);
      }
    },

    checkForm: function (e) {
      
      if(this.isSignup){
        this.signUp();
      }else{
        this.logIn();
      }

      return true;
      
      e.preventDefault();
    },
  },
};
</script>

<style scoped>
</style>