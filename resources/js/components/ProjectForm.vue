<template>
  <div class="bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-md">
    <img 
      class="mx-auto h-12 w-auto" 
      src="/storage/logos/lightit-logo.png" 
      alt="LightIt-Logo">
    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
      {{title}}
    </h2>
  </div>

  <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
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
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
import VueToast from 'vue-toast-notification';
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
      projectToEdit: Object,
    },

    methods:{

      async crateProject(){

        try{
          const response = await axios.post('/api/projects', this.project);
          Vue.$toast.success(response.data.message);
          window.location.href = '/projects';
        }catch(e){
          Vue.$toast.error(e);
        }

      },

      async editProject(){

        try{
          const response = await axios.put('/api/projects/' + this.projectToEdit.id, this.project);
          Vue.$toast.success(response.data.message);
          window.location.href = '/projects';
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
      }
    },

    mounted(){
      let user = JSON.parse(localStorage.user);
      this.project.userId = user.id;

      if(!this.isNew){
        this.project.name = this.projectToEdit.name;
        this.project.description = this.projectToEdit.description;
        this.project.id = this.projectToEdit.id;
      }

    }
  }
</script>

<style scoped>

</style>