<template>
  <div :class="{
    'bg-white pb-4 px-2 md:px-4 rounded-md w-full': $root.onLine === true || $root.onLine === null,
    'bg-white pb-4 px-2 md:px-4 rounded-md w-full opacity-20 pointer-events-none': $root.onLine === false,
    }"
  >
    <div class="w-full pt-6 grid grid-cols-6 grid-rows-2 md:relative md:flex justify-center items-center ">
      <BackButton class="col-span-1 row-start-1"></BackButton>
      <h2 class="mb-2 md:m-0 text-center col-span-4 row-start-1 row-end-1">{{project.name}}</h2>

      <div class="text-center md:absolute md:right-0 col-span-6 row-start-2">
        <button @click="$router.push({name:'epic', params:{id:'new', projectId: project.id}})" type="button" class="basicButton">New Epic</button>
        <button @click="$router.push({name:'project-dashboard', props:{id: project.id}})" class="basicButton">Dashboard</button>
      </div>

    </div>
    
    <div v-if="projectLoaded && project.epics.length > 0">
      <Epic
        v-for="(epic, index) in project.epics" :key="index" 
        v-bind:epic="epic"
        @delete-user-story="deleteUserStory($event)"
        @delete-epic="showDeleteModal($event, index)"
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
        epicIndexToDelete: null,
        deleteModal: false,
        projectLoaded:false,
      }
    },

    components:{EpicEditor, Epic, DeleteModal, BackButton},

    methods:{

      async deleteEpic(){
        try{
          const response = await axios.get('/api/auth/epics/' + this.epicIdToDelete + '/delete');
          if(response.status === 200 && response.data.success === true){
            Vue.$toast.success(response.data.message);
            this.project.epics.splice(this.epicIndexToDelete, 1);
            this.epicIdToDelete = null;
            this.epicIndexToDelete = null;
          }
        }catch(e){
          Vue.$toast.error(e.response.data.message);
        }finally{
          this.deleteModal = false;
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
        this.epicIdToDelete = null;
        this.epicIndexToDelete = null;
      },

      showDeleteModal: function(epicId, epicIndex){
        this.epicIdToDelete = epicId;
        this.epicIndexToDelete = epicIndex;
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

      Echo.private('project-channel.' + this.$route.params.id)
      .listen('ProjectUpdateEvent', (e) => {
        //Which is more accurate? Sending Project id from router or from the event?
        //From router
        //this.getProject(this.$route.params.id);
        //From event
        this.getProject(e.project.id);
      });
    },

    beforeDestroy(){
      Echo.leaveChannel(`private-project-channel.${this.project.id}`);
    },
    
  }
</script>

<style scoped>

</style>