<template>
  <div class="bg-gray-50 flex flex-col justify-center pb-8 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <img 
        class="mx-auto h-14 w-auto" 
        src="/storage/logos/lightit-logo.png" 
        alt="LightIt-Logo">
    </div>
    <div class="w-full pt-6 mb-2 grid grid-cols-6 md:flex justify-center items-center md:relative">
        <BackButton class="col-span-1"></BackButton>
        <h2 class="col-span-4 m-0 text-center text-3xl font-extrabold text-gray-900">{{title}}</h2>
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
            <div>
              <ValidationProvider name="Name" rules="required" v-slot="{errors}">
                <label for="name" class="block text-sm font-medium text-gray-700">
                  Name
                </label>
                <div class="mt-1">
                  <input
                    id="name" 
                    name="name" 
                    type="text"
                    v-model="project.name"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div v-if="errors[0]" class="mt-2">
                      <span class="error-text">{{errors[0]}}</span>
                </div>
              </ValidationProvider>
            </div>

            <div>
              <ValidationProvider name="Description" rules="required" v-slot="{errors}">
                <label for="description" class="block text-sm font-medium text-gray-700">
                  Description
                </label>
                <div class="mt-1">
                  <textarea
                    id="description" 
                    name="description"  
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    rows="10"
                    v-model="project.description"
                    >
                  </textarea>
                </div>
                <div v-if="errors[0]" class="mt-2">
                    <span class="error-text">{{errors[0]}}</span>
                </div>
              </ValidationProvider>
            </div>

            <div>
              <button type="submit" class="basicButton w-full flex justify-center">
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

        project:{
          id: null,
          name: "",
          description: "",
          userId: null
        },

      }
    },

    props:{
      title: String,
      buttonText: String,
      isNew: Boolean,
    },

    components:{BackButton},

    methods:{

      async crateProject(){
        try{
          const response = await axios.post('/api/auth/projects', this.project);
          if(response.status === 200 && response.data.success === true){
            Vue.$toast.success(response.data.message);
            this.$router.push('/projects'); 
          }
        }catch(e){
          Vue.$toast.error(e);
        }
      },

      async editProject(){
        try{
          const response = await axios.put('/api/auth/projects/' + this.project.id, this.project);
          if(response.status === 200 && response.data.success === true){
            Vue.$toast.success(response.data.message);
            this.$router.push('/projects');
          }
        }catch(e){
          Vue.$toast.error(e);
        }
      },

      checkForm: function(e){

        if(this.isNew){
          this.crateProject();
        }else{
          this.editProject();
        }
        return true;
        e.preventDefault();
      },

      async getProjectToEdit(projectId){
        try{
          const response = await axios.get('/api/auth/projects/' + projectId + '/edit');
          if(response.status === 200 && response.data.success === true){
            this.project = response.data.project;
          }
        }catch(e){
          Vue.$toast.error(e);
        }
      }
    },

    mounted(){
      const user = JSON.parse(localStorage.user);
      this.project.userId = user.id;

      if(!this.isNew){
        this.getProjectToEdit(this.$route.params.id);
      }
    }
  }
</script>

<style scoped>

</style>