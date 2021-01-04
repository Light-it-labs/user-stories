<template>
  <div>
    <div class="bg-white pb-4 px-4 rounded-md w-full">
      <div class="w-full flex justify-end px-2 mt-2 items-baseline">
        <div class="w-full pt-6 ">
          <h2 class="ml-3"> Projects</h2>
        </div>
          <div class="w-full sm:w-64 inline-block relative ">
            <input 
              type="" 
              name="" 
              class="leading-snug border border-gray-300 block w-full appearance-none bg-gray-100 text-sm text-gray-600 py-1 px-4 pl-8 rounded-lg ml-2"
              placeholder="Search" />

            <div class="pointer-events-none absolute pl-3 inset-y-0 left-0 flex items-center px-2 text-gray-300">

              <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.999 511.999">
                <path d="M508.874 478.708L360.142 329.976c28.21-34.827 45.191-79.103 45.191-127.309C405.333 90.917 314.416 0 202.666 0S0 90.917 0 202.667s90.917 202.667 202.667 202.667c48.206 0 92.482-16.982 127.309-45.191l148.732 148.732c4.167 4.165 10.919 4.165 15.086 0l15.081-15.082c4.165-4.166 4.165-10.92-.001-15.085zM202.667 362.667c-88.229 0-160-71.771-160-160s71.771-160 160-160 160 71.771 160 160-71.771 160-160 160z" />
              </svg>
            </div>
          </div>
      </div>

      <div class="overflow-x-auto mt-6">
        <div class="flex items-center justify-between flex-wrap sm:flex-nowrap mb-4">
          <div class="ml-4 mt-2">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
              Projects
            </h3>
          </div>
          <div class="ml-4 mt-2 flex-shrink-0">
            <a href="/projects/create" class="basicButton">
              New Project
            </a>
          </div>
        </div>

        <table 
          v-if="projects.length > 0"
          class="table-auto border-collapse w-full">
          <thead>
            <tr class="rounded-lg text-sm font-medium text-gray-700 text-left" style="font-size: 0.9674rem">
              <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Name</th>
              <th class="px-4 py-2 hidden md:table-cell" style="background-color:#f8f8f8">Description</th>
              <th class="px-4 py-2 text-right" style="background-color:#f8f8f8">Actions</th>
            </tr>
          </thead>
          <tbody class="text-sm font-normal text-gray-700">

            <tr class="hover:bg-gray-100 border-b border-gray-200 py-10" v-for="project in projects" :key="project.id">
              <td class="px-4 py-4">{{project.name}}</td>
              <td class="px-4 py-4 hidden md:table-cell">{{project.description}}</td>
              <td class="px-6 py-4 text-right text-sm font-medium flex flex-col flex-end">
                <a :href="'/projects/' + project.id + '/edit'" class="text-indigo-600 hover:text-indigo-900 mb-2">Edit</a>
                <a :href="'/users/invite/?project_id=' + project.id" class="text-indigo-600 hover:text-indigo-900 mb-2">Invite</a>
                <a @click="showDeleteModal(project.id)" class="text-indigo-600 hover:text-indigo-900">Delete</a>
              </td>
            </tr>

          </tbody>
        </table>

        <div v-else>
          <p class="text-center">No projects at the moment</p>
        </div>
      </div>

      <Delete-Modal v-if="deleteModal"
        title="Delete Project" 
        message="Are you sure you want to delete this project"
        left-button="Cancel"
        right-button="Confirm"
        @close-delete-modal="closeDeleteModal()"
        @delete-project="deleteProject()"
      >
      </Delete-Modal>
    
    </div>
  </div>
</template>

<script>
import DeleteModal from './DeleteModal.vue';

  export default {
    data(){
      return{
        deleteModal: false,
        projectIdToDelete: null

      }
    },

    components: {DeleteModal},

    props:{
      projects: Array
    },

    methods:{
      showDeleteModal: function(id){
        this.projectIdToDelete = id;
        this.deleteModal = true;
      },

      closeDeleteModal: function(){
        this.deleteModal = false;
      },

      async deleteProject(){
        try{
          const response = await axios.get('/api/projects/' + this.projectIdToDelete + '/delete');
          this.deleteModal = false;
          Vue.$toast.success(response.data.message);
          location.reload();

        }catch(e){
          Vue.$toast.error(e);
        }
      }
    }
  }
</script>

<style>

  thead tr th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px;}
  thead tr th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px;}
  
  tbody tr td:first-child { border-top-left-radius: 5px; border-bottom-left-radius: 0px;}
  tbody tr td:last-child { border-top-right-radius: 5px; border-bottom-right-radius: 0px;}
  
  
</style>