<template>
  <div class="bg-white pb-4 px-4 rounded-md w-full">
    <div class="w-full pt-6 ">
      <h2 class="ml-3 text-center">{{project.name}}</h2>
    </div>
  <!-- v-if="project.epics.length > 0" -->
    <div >
      <Epic
        v-for="(epic, index) in project.epics" :key="index" 
        v-bind:epic="epic"
        @delete-user-story="deleteUserStory($event)"
        @delete-epic="showDeleteModal($event)"
      ></Epic>
    </div>
    <!-- v-else -->
    <div>
      <p class="text-center my-2">No Epics at the moment</p>
    </div>
    

    <div class="text-center">
      <button @click="$router.push({name:'Epic', params:{id:'new', projectId: project.id}})" type="button" class="basicButton">New Epic</button>
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

  export default {
    data(){
      return{
        project:{},
        epicIdToDelete: null,
        deleteModal: false,
      }
    },

    components:{EpicEditor, Epic, DeleteModal},

    methods:{

      async deleteEpic(){
        try{
          const response = await axios.get('/api/epics/' + this.epicIdToDelete + '/delete');
          if(response.status === 200 && response.data.success === true){
            this.deleteModal = false;
            this.epicIdToDelete = null;
            Vue.$toast.success(response.data.message);
            this.$router.go();
          }
        }catch(e){
          Vue.$toast.error(e);
        }
      },

      async deleteUserStory(objectEpicIdUserStory){
        try{
          const response = await axios.get('/api/user-stories/' + objectEpicIdUserStory.userStory.userStoryId + '/delete');
          if(response.status === 200 && response.data.success === true){
            Vue.$toast.success(response.data.message);

            const epic = this.project.epics.find(item => item.id === objectEpicIdUserStory.epicId);
            epic.user_stories.splice(objectEpicIdUserStory.userStory.userStoryIndex, 1);
          }
        }catch(e){
          Vue.$toast.error(e);
        }
      },

      async getProject(projectId){
        try{
          const response = await axios.get('/api/projects/' + projectId);
          if(response.status === 200 && response.data.success === true){
            this.project = response.data.project;
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
      }else{
        this.getProject(this.$route.params.id);
      }
      
    }
    
  }
</script>

<style scoped>

</style>