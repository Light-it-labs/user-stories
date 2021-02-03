<template>
  <div :class="{
    'bg-white pb-4 px-4 rounded-md w-full': $root.onLine === true || $root.onLine === null,
    'bg-white pb-4 px-4 rounded-md w-full opacity-20 pointer-events-none': $root.onLine === false,
    }"
  >

    <h2>{{title}}</h2>

     <div class="mt-2 sm:w-full bg-white shadow sm:rounded-lg">
       <ValidationObserver v-slot="{ handleSubmit }">
        <form 
          action="" 
          method="POST"
          @submit.prevent="handleSubmit(checkForm)"
        >
            <div class="py-6 px-4  sm:px-10">

                <div>
                  <ValidationProvider name="Description" rules="required" v-slot="{errors}">
                    <label for="description" class="block text-sm font-medium text-gray-700">
                      Description
                    </label>
                    <div class="mt-1">
                      <textarea 
                        id="description" 
                        name="description"
                        v-model="epic.description" 
                        placeholder="Enter epic description"
                        rows="2"
                        cols="10"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      </textarea>
                    </div>
                    <div v-if="errors[0]" class="my-1">
                        <span class="error-text">{{errors[0]}}</span>
                    </div>
                  </ValidationProvider>
                </div>
                
            

              <div class="bg-gray-600 p-4 border-t-2 bg-opacity-5 border-indigo-400 rounded-t mt-4">
                <div class="flex justify-between items-center md:w-full md:mx-0">
                  <h2 class="font-medium text-gray-700">User Stories</h2>
                  <button 
                    v-if="!showUserStoryForm"
                    @click="addUserStory()" 
                    type="button" 
                    class="circleButton"
                  >+
                </button>
                </div>
                
                <ul v-if="epic.user_stories.length > 0">
                  <hr class="mt-2">
                  <li 
                    v-for="(userStory, index) in epic.user_stories" :key="index"
                    class="flex justify-between my-1"
                  >
                    <span>{{userStory.description}}</span>
                    <div>
                      <button @click="editUserStory(userStory, index)" type="button"><i class="fa fa-edit"></i></button>
                      <button @click="epic.user_stories.splice(index, 1)" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </div>
                    
                  </li>
                  <hr>
                </ul>


                <User-Story-Form 
                  v-if="userStoryForm"
                  v-bind:userStoryToEditProp="userStoryToEdit"
                  v-bind:index="userStoryIndex"
                  @save-user-story="saveNewUserStory($event)"
                  @edit-user-story="saveEditedUserStory($event)"
                  @cancel-new-user-story="cancelNewUserStory()"
                >
              </User-Story-Form> 
              </div>
            </div>

            <div class="text-center my-4">
              <button type="submit" class="basicButton">Save</button>
            </div>
          </form>
       </ValidationObserver>
      </div>
  </div>
</template>

<script>
import UserStoryForm from './UserStoryForm.vue';

export default {
  data(){
    return{
      epic:{
        project_id: null,
        description: "",
        user_stories:[]
      },
      showUserStoryForm: false,
      userStoryToEdit: {},
      userStoryIndex: null,
      title:"",
    }
  },

  components:{UserStoryForm},

  props:{
    projectIdProp:Number,
  },

  computed:{
    userStoryForm: function(){
      return this.showUserStoryForm;
    }
  },

  methods:{

    async editEpic(){
        try{
          const response = await axios.put('/api/auth/epics/' + this.epic.id, this.epic);
          if(response.status === 200 && response.data.success === true){
            Vue.$toast.success(response.data.message);
            this.$router.push({name: 'project', params:{id: this.epic.project_id}});
          }
        }catch(e){
          Vue.$toast.error(e);
        }   
    },

    async saveEpic(){
      try{
        const response = await axios.post('/api/auth/epics', this.epic);
        if(response.status === 200 && response.data.success === true){
          Vue.$toast.success(response.data.message);
          this.$router.push({name: 'project', params:{id: this.epic.project_id}});
        }
      }catch(e){
        Vue.$toast.error(e);
      }
    },

    async getEpicToEdit(epicId){
      try{
        const response = await axios.get('/api/auth/epics/' + epicId + '/edit');
        if(response.status === 200 && response.data.success === true){
          this.epic = response.data.epic;
        }
      }catch(e){
        Vue.$toast.error(e.response.data.message);
        this.$router.push({name: 'project', params: {id: this.$route.params.projectId}});
      }
    },

    cancelNewUserStory: function(){
      this.showUserStoryForm = false;
      this.userStoryToEdit = {};
    },

    editUserStory: function(userStory, index){
      this.userStoryIndex = index;
      this.showUserStoryForm = true;
      this.userStoryToEdit = userStory
    },

    saveEditedUserStory: function(userStoryWithIndex){
      this.epic.user_stories[userStoryWithIndex.index] = userStoryWithIndex.userStory;
      this.userStoryToEdit = {};
      this.showUserStoryForm = false;
    },

    saveNewUserStory: function(userStory){
      this.epic.user_stories.unshift(userStory);
      this.showUserStoryForm = false;
    },

    addUserStory: function(){
      this.showUserStoryForm = true;
    },



    checkForm: function(e){
      if(this.$route.params.id != 'new'){
        this.editEpic();
      }else{
        this.saveEpic();
      }
    },

    evaluateUserStory(paramId){
      if(paramId != 'new'){
        this.getEpicToEdit(paramId);
        this.title = "Edit Epic"
      }else{
        this.title = "New Epic"
      }
    },

  },

  mounted(){
    const access_token = JSON.parse(localStorage.access_token);
    axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`;
    this.epic.project_id = this.$route.params.projectId;
    this.evaluateUserStory(this.$route.params.id);
    window.onunload = () => {
      fetch('/api/auth/epics/' + this.$route.params.id + '/reset-status', {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${access_token}`
          },
          keepalive: true
      });
    }
  
  },

  created() {
    window.onbeforeunload = function (){
      this.resetEpicStatus(this.$route.params.id);
    }
  },
}
</script>

<style scoped>

</style>