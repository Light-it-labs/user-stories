<template>
  <div class="bg-white pb-4 px-4 rounded-md w-full">
    <div class="w-full pt-6 ">
      <h2 class="ml-3 text-center">{{project.name}}</h2>
    </div>
    <ul>
      <li v-for="(epic, index) in projectEpics" :key="index">
        <span>{{epic.description}}</span>
      </li>
    </ul>
    <Epic-Editor 
      v-if="showEpicEditor"
      v-bind:projectIdProp="project.id" 
      @add-epic="saveEpic($event)"
    >
    </Epic-Editor>
    <button @click="showEpicEditor = true" type="button" class="basicButton">New Epic</button>
  </div>
</template>

<script>
import EpicEditor from './EpicEditor';

  export default {
    data(){
      return{

        projectEpics:[],
        showEpicEditor: false,
      }
    },

    components:{EpicEditor},

    props:{
      project: Object,
      epics: Array
    },

    methods:{
      async saveEpic(epic){
        try{
          this.showEpicEditor = false;
          const response = await axios.post('/api/epics', epic);
          Vue.$toast.success(response.data.message);
          

        }catch(e){
          Vue.$toast.error(e);
        }
      },

    },

    mounted(){
      this.projectEpics = this.epics;
    }
    
  }
</script>

<style scoped>

</style>