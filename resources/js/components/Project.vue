<template>
  <div class="bg-white pb-4 px-4 rounded-md w-full">
    <div class="w-full pt-6 flex justify-center items-center relative">
      <BackButton></BackButton>
      <h2 class="m-0 text-center">{{project.name}}</h2>

      <div class="text-center absolute right-0">
        <button @click="$router.push({name:'epic', params:{id:'new', projectId: project.id}})" type="button" class="basicButton">New Epic</button>
        <button @click="$router.push({name:'project-dashboard', props:{id: project.id}})" class="basicButton">Dashboard</button>
      </div>

    </div>
    
    <div v-if="projectLoaded && project.epics.length > 0">
      <Epic
        v-for="(epic, index) in project.epics" :key="index" 
        v-bind:epic="epic"
        @delete-user-story="deleteUserStory($event)"
        @delete-epic="showDeleteModal($event)"
      ></Epic>
    </div>
    
    <div v-else>
      <p class="text-center my-2">No Epics at the moment</p>
    </div>
    

    

    <Delete-Modal v-if="deleteModal"
        title="Delete Epic" 
        message="Are you sure you want to delete this epic"
        left-button="Cancel"
        right-button="Confirm"
        @close-delete-modal="closeDeleteModal()"
        @delete-confirm="deleteEpic()"
      >
      </Delete-Modal>
    
  </div>
</template>

<script>
import EpicEditor from './EpicEditor.vue';
import Epic from './Epic.vue';
import DeleteModal from './DeleteModal.vue';
import BackButton from './BackButton.vue';

  export default {
    data(){
      return{
        project:{},
        epicIdToDelete: null,
        deleteModal: false,
        projectLoaded:false
      }
    },

    components:{EpicEditor, Epic, DeleteModal, BackButton},

    methods:{

      async deleteEpic(){
        try{
          const response = await axios.get('/api/auth/epics/' + this.epicIdToDelete + '/delete');
          if(response.status === 200 && response.data.success === true){
            this.deleteModal = false;
            this.epicIdToDelete = null;
          }
        }catch(e){
          Vue.$toast.error(e);
        }
      },

      async deleteUserStory(objectEpicIdUserStory){
        try{
          const response = await axios.get('/api/auth/user-stories/' + objectEpicIdUserStory.userStory.userStoryId + '/delete');
          if(response.status === 200 && response.data.success === true){
            Vue.$toast.success(response.data.message);
            const epic = this.project.epics.find(item => item.id === objectEpicIdUserStory.epicId);
            epic.user_stories.splice(objectEpicIdUserStory.userStory.userStoryIndex, 1);
          }
        }catch(e){
          Vue.$toast.error(e.response.data.message);
        }
      },

      async getProject(projectId){
        try{
          const response = await axios.get('/api/auth/projects/' + projectId);
          if(response.status === 200 && response.data.success === true){
            this.project = response.data.project;
            this.projectLoaded = true;
          }
        }catch(e){
          Vue.$toast.error(e);
        }
      },

      closeDeleteModal: function(){
        this.deleteModal = false;
      },

      showDeleteModal: function(epicId){
        this.epicIdToDelete = epicId;
        this.deleteModal = true;
      }

    },

    mounted(){
      if('objectProject' in this.$route.params){
        this.project = this.$route.params.objectProject;
        this.projectLoaded = true;
      }else{
        this.getProject(this.$route.params.id);
      } 
    },

     created(){
      Echo.private('project-channel.' + this.$route.params.id)
      .listen('ProjectUpdateEvent', (e) => {
        //Which is more accurate? Sending Project id from router or from the event?
        //From router
        //this.getProject(this.$route.params.id);
        //From event
        this.getProject(e.project.id);
      });
     }
    
  }
</script>

<style scoped>

</style>