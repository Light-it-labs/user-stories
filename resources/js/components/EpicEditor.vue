<template>
  <div v-if="epicLoaded" :class="{
    'min-h-screen flex flex-col pb-2 sm:px-2 lg:px-8': $root.onLine === true || $root.onLine === null,
    'min-h-screen flex flex-col pb-2 sm:px-2 lg:px-8 opacity-20 pointer-events-none': $root.onLine === false,
  }">
    
    <div class="w-full mb-2 flex justify-center items-center relative">
      <BackButton></BackButton>
      <h2 class="m-0">{{title}}</h2>
    </div>

    <LastSaved
      v-if="!hideTimeSaved"
      ref="lastSaved"
      v-bind:savingStatus="savingEpic"
      v-bind:timeInitialized="epic.updated_at"
    >
    </LastSaved>
    

     <div class="mt-2 sm:w-full bg-white shadow sm:rounded-lg">
       <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
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
            

              <div class="bg-gray-600 p-4 border-t-2 bg-opacity-5 border-gray-400 rounded mt-4">
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
                      <button @click="deleteUserStory(userStory, index)" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </div>
                    
                  </li>
                  <hr>
                </ul>

                <UserStoryForm 
                  v-if="showUserStoryForm"
                  v-bind:userStoryToEditProp="userStoryToEdit"
                  v-bind:index="userStoryIndex"
                  @save-user-story="saveNewUserStory($event)"
                  @edit-user-story="saveEditedUserStory($event)"
                  @cancel-new-user-story="closeUserStoryForm()"
                  @close-user-story-form="closeUserStoryForm()"
                >
              </UserStoryForm> 
              </div>
            </div>

          </form>
       </ValidationObserver>
      </div>
  </div>
</template>

<script>
import UserStoryForm from './UserStoryForm.vue';
import LastSaved from './LastSaved.vue';
import _ from 'lodash';
import BackButton from './BackButton.vue';

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
      watchInPause: true,
      savingEpic: false,
      isUserAvailable: false,
      epicLoaded: false,
      hideTimeSaved: false,
    }
  },

  components:{UserStoryForm, BackButton, LastSaved},

  props:{
    projectIdProp:Number,
  },

  watch:{
    epic:{
      handler: function(){
        if(!this.watchInPause){
          this.hideTimeSaved = false;
          this.savingEpic = true;
          this.saveChanges();
        }
        this.watchInPause = false;
      },

      immediate:false,
      deep:true
    },
  },

  methods:{

    async editEpic(){
        try{
          const response = await axios.put('/api/auth/epics/' + this.epic.id, this.epic);
          if(response.status === 200 && response.data.success === true){
            this.watchInPause = true;
            this.epic = response.data.epic;
          }
        }catch(e){
          Vue.$toast.error(e);
          
        }finally{
          this.savingEpic = false;
          this.epic.user_stories[this.userStoryIndex] = this.userStoryToEdit;
        }
    },

    async saveEpic(){
      try{
        const response = await axios.post('/api/auth/epics', this.epic);
        if(response.status === 200 && response.data.success === true){
          this.epic = response.data.epic;
          //I'am supposed to change the route with the id of the new epic? The route params is already change
          // but the route path displayed for the user is not.
          // this.$route.path = `/projects/${this.$route.params.projectId}/${this.epic.id}`;
          this.$route.params.id = this.epic.id;
        }
      }catch(e){
        Vue.$toast.error(e);
        
      }finally{
        this.savingEpic = false;
        
      }
    },

    async getEpicToEdit(epicId){
      try{
        const response = await axios.get('/api/auth/epics/' + epicId + '/edit');
        if(response.status === 200 && response.data.success === true){
          this.watchInPause = true;
          this.epic = response.data.epic;
          this.isUserAvailable = true;
          this.epicLoaded = true;
        }
      }catch(e){
        Vue.$toast.error(e.response.data.message);
        this.$router.push({name: 'project', params: {id: this.$route.params.projectId}});
      }
    },

    async deleteUserStory(userStory, index){
      const response = await axios.get('/api/auth/user-stories/' + userStory.id + '/delete');
      if(response.status === 200 && response.data.success === true){
        this.epic.user_stories.splice(index, 1);
        if(this.userStoryIndex === index){
          this.showUserStoryForm = false;
          this.userStoryToEdit = {};
          this.userStoryIndex = null;    
        }
      }
    },

    closeUserStoryForm: function(){
      this.showUserStoryForm = false;
      this.userStoryToEdit = {};
      this.userStoryIndex = null;
    },

    editUserStory: function(userStory, index){
      this.userStoryIndex = index;
      this.showUserStoryForm = true;
      this.userStoryToEdit = userStory
    },

    saveEditedUserStory: function(userStoryWithIndex){
      this.epic.user_stories[userStoryWithIndex.index] = userStoryWithIndex.userStory;
      this.editEpic();
    },

    saveNewUserStory: function(userStory){
      this.epic.user_stories.unshift(userStory);
      this.showUserStoryForm = false;
      this.userStoryIndex = null;
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
        this.epicLoaded = true;
        this.hideTimeSaved = true;
      }
    },

     saveChanges: _.debounce(function(){
      if (!this.$refs.observer.flags.invalid){
        this.checkForm();
      }else{
        this.savingEpic = false;
      }
     },2000)

  },

  mounted(){
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

  beforeRouteLeave(to, from, next){
    if(this.isUserAvailable){
      axios.get('/api/auth/epics/' + this.$route.params.id + '/reset-status')
      .then(response => {
        next();
      })
      .catch(error => {
        Vue.$toast.error(error);
        next(false);
      });
    }else{
      next();
    }
  }
}
</script>

<style scoped>

</style>