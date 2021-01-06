<template>
  <div class="shadow-div"
    @click="showUserStories = !showUserStories"
  >
    <div class="flex justify-between items-center  ">
      <div class="flex">
        <h3 class="font-bold">{{epic.description}}</h3>
        <div v-if="showUserStories" class="ml-2">
          <button @click="editEpic(epic.id)" type="button"><i class="fa fa-edit"></i></button>
          <button type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
        </div>
      </div>
      
      <i
        v-if="!showUserStories"
        class="fa fa-chevron-circle-down text-2xl hover:pointer"
      ></i>
      <div v-if="showUserStories">
        <!-- <button type="button"><i class="fa fa-edit"></i></button>
        <button type="button"><i class="fa fa-trash" aria-hidden="true"></i></button> -->
        <i class="fa fa-chevron-circle-up text-2xl hover:pointer"></i>
      </div>
      
    </div>

    <transition
      enter-active-class="transition ease-out origin-top-left duration-200"
      enter-class="transform opacity-0 scale-90"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition origin-top-left ease-in duration-100"
      leave-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-90"  
    >

      <div v-if="(showUserStories && epic.user_stories.length > 0)"
        class="mt-2">
        <div 
          v-for="(userStory, index) in epic.user_stories" :key="index"
          class="less-shadow-div flex justify-between items-center"
          
        >
          <p>{{userStory.description}}</p>
          <div>
            <button @click="$router.push({name:'UserStory', params:{objectUserStory: userStory}})" type="button"><i class="fa fa-edit"></i></button>
            <button @click="deleteUserStory({userStoryId:userStory.id, userStoryIndex: index})" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
          </div>
        </div>
      </div>
      <div
        v-if="showUserStories && epic.user_stories.length < 1"
      >
        <p class="mt-2">No User Stories at the moment!</p>
      </div>
    </transition>

  </div>
</template>

<script>
  export default {
    data(){
      return{
        showUserStories: false,

      }
    },

    props:{
      epic: Object,
    },

    computed:{
      showUserStoriesBool: function(){
        if (this.showUserStories === false){
          return true;
        }else{
          return false;
        }
      }
    }, 

    methods:{
      editEpic: function(epicId){
        this.$router.push({name:'Epic', params:{projectId:this.epic.project_id,id: this.epic.id, epic:this.epic}});
      },

      deleteUserStory: function(userStory){
        this.$emit('delete-user-story', { epicId: this.epic.id, userStory: userStory});
      },

    }


  }
</script>

<style scoped>

</style>