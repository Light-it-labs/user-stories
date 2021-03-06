<template>
  <div :class="{
    '': $root.onLine === true || $root.onLine === null,
    'opacity-20 pointer-events-none': $root.onLine === false,
    }">

    <div v-if="epicExists && userStoryLoaded">
      <div class="w-full pt-6 mb-2 flex justify-center items-center relative">
        <BackButton></BackButton>
        <h2 class="m-0">Edit User Story</h2>
      </div>
      <LastSaved 
        ref="lastSaved"
        v-bind:savingStatus="savingUserStory"
        v-bind:timeInitialized="userStory.updated_at"
      >
      </LastSaved>
    </div>
    

    <div class="mt-2 sm:w-full bg-white shadow sm:rounded-lg">
      <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
        <form 
            action="" 
            method="POST"
            @submit.prevent="handleSubmit(checkForm)"
        >
              <div class="p-6 px-4 sm:px-10">
                <div v-if="!epicExists">
                  <button class="button absolute inset-x-3/4" @click="$emit('close-user-story-form')">X</button>
                </div>

                <div class="mb-2">
                  <ValidationProvider name="Description" rules="required" v-slot="{errors}">
                    <label for="description" class="block text-sm font-medium text-gray-700">
                      Description
                    </label>
                    <div class="mt-1">
                      <textarea 
                        id="description" 
                        name="description"
                        v-model="userStory.description" 
                        placeholder="Enter description"
                        rows="2"
                        cols="8"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      </textarea>
                    </div>
                    <div v-if="errors[0]" class="my-1">
                      <span class="error-text">{{errors[0]}}</span>
                    </div>
                  </ValidationProvider>
                </div>

                <div class="grid grid-cols-3 gap-2 mb-2">

                  <div class="col-span-3 md:col-span-1">
                    <ValidationProvider name="Priority" rules="required|between:1,4" v-slot="{errors}">
                      <label for="priority" class="block text-sm font-medium text-gray-700">
                        Priority
                      </label>  
                      <div class="flex flex-wrap">
                        <div class="flex w-8/12">
                          <select 
                            name="priority" 
                            id="priority"
                            v-model="userStory.priority"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                          >
                            <option value="-1">Select priority...</option>
                            <option value="1">1 High</option>
                            <option value="2">2 Med</option>
                            <option value="3">3 Med</option>
                            <option value="4">4 Low</option>
                          </select>
                        </div>
                        <div class="flex flex-col w-4/12">
                          <button
                            :disabled="increaseButtonisDisable('priority')"
                            type="button"
                            @click="increasePriority"
                            class="text-white text-center text-md font-semibold rounded-tr-md px-1 bg-gray-800 focus:bg-gray-600 focus:outline-none border border-gray-800 focus:border-gray-600">
                          +
                          </button>
                          <button
                            :disabled="decreaseButtonisDisable('priority')"
                            type="button"
                            @click="decreasePriority"
                            class="text-white text-center text-md font-semibold rounded-br-md px-1 bg-gray-800 focus:bg-gray-600 focus:outline-none border border-gray-800 focus:border-gray-600">
                          -
                          </button>
                        </div>
                        <div v-if="errors[0]" class="my-1">
                          <span class="error-text">{{errors[0]}}</span>
                        </div>
                      </div>
                    </ValidationProvider>
                  </div>

                  <div class="col-span-3 md:col-span-1">
                    <ValidationProvider name="Risk" rules="required|between:1,4" v-slot="{errors}">
                      <label for="risk" class="block text-sm font-medium text-gray-700">
                        Risk
                      </label>  
                      <div class="flex flex-wrap">
                        <div class="flex w-8/12">
                          <select 
                            name="risk" 
                            id="risk"
                            v-model="userStory.risk"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                          >
                            <option value="-1">Select risk...</option>
                            <option value="1">1 High</option>
                            <option value="2">2 Med</option>
                            <option value="3">3 Med</option>
                            <option value="4">4 Low</option>
                          </select>
                        </div>
                        <div class="flex flex-col w-4/12">
                          <button
                            :disabled="increaseButtonisDisable('risk')"
                            type="button"
                            @click="increaseRisk"
                            class="text-white text-center text-md font-semibold rounded-tr-md px-1 bg-gray-800 focus:bg-gray-600 focus:outline-none border border-gray-800 focus:border-gray-600">
                          +
                          </button>
                          <button
                            :disabled="decreaseButtonisDisable('risk')"
                            type="button"
                            @click="decreaseRisk"
                            class="text-white text-center text-md font-semibold rounded-br-md px-1 bg-gray-800 focus:bg-gray-600 focus:outline-none border border-gray-800 focus:border-gray-600">
                          -
                          </button>
                        </div>
                        <div v-if="errors[0]" class="my-1">
                          <span class="error-text">{{errors[0]}}</span>
                        </div>
                      </div>
                    </ValidationProvider>
                  </div>

                  <div class="col-span-3 md:col-span-1">
                    <ValidationProvider name="Value" rules="required|between:1,4" v-slot="{errors}">
                      <label for="value" class="block text-sm font-medium text-gray-700">
                        Value
                      </label>  
                      <div class="flex flex-wrap">
                        <div class="flex w-8/12">
                          <select 
                            name="value" 
                            id="value"
                            v-model="userStory.value"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                          >
                            <option value="-1">Select value...</option>
                            <option value="1">1 High</option>
                            <option value="2">2 Med</option>
                            <option value="3">3 Med</option>
                            <option value="4">4 Low</option>
                          </select>
                        </div>
                        <div class="flex flex-col w-4/12">
                          <button
                          :disabled="increaseButtonisDisable('value')"
                            type="button"
                            @click="increaseValue"
                            class="text-white text-center text-md font-semibold rounded-tr-md px-1 bg-gray-800 focus:bg-gray-600 focus:outline-none border border-gray-800 focus:border-gray-600">
                          +
                          </button>
                          <button
                            :disabled="decreaseButtonisDisable('value')"
                            type="button"
                            @click="decreaseValue"
                            class="text-white text-center text-md font-semibold rounded-br-md px-1 bg-gray-800 focus:bg-gray-600 focus:outline-none border border-gray-800 focus:border-gray-600">
                          -
                          </button>
                        </div>
                        <div v-if="errors[0]" class="my-1">
                          <span class="error-text">{{errors[0]}}</span>
                        </div>
                      </div>
                    </ValidationProvider>
                  </div>
                </div>

                <div class="mb-2">
                  <ValidationProvider name="Estimate" :rules="{regex: /^(XXS|XS|S|M|L|XL|XXL)$/}" v-slot="{errors}">
                    <label for="estimate" class="block text-sm font-medium text-gray-700">
                      Estimate
                    </label>
                    <div class="mt-1">
                      <select 
                        name="estimate" 
                        id="estimate"
                        v-model="userStory.estimate"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    >
                        <option value="-1">Select size...</option>
                        <option value="XXS">XXS</option>
                        <option value="XS">XS</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                      </select> 
                    </div>
                    <div v-if="errors[0]" class="my-1">
                      <span class="error-text">{{errors[0]}}</span>
                    </div>
                  </ValidationProvider>
                </div>

                <div class="mb-2">
                  <label for="acceptance" class="block text-sm font-medium text-gray-700">
                    Acceptance
                  </label>
                  <div class="mt-1">
                    <textarea 
                      id="acceptance" 
                      name="acceptance"
                      v-model="userStory.acceptance" 
                      placeholder="Enter acceptance..."
                      rows="2"
                      cols="8"
                      class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </textarea>
                  </div>
                </div>

                <div class="mb-2">
                  <label for="notes" class="block text-sm font-medium text-gray-700">
                    Notes
                  </label>
                  <div class="mt-1">
                    <textarea 
                      id="notes" 
                      name="notes"
                      v-model="userStory.notes" 
                      placeholder="Enter notes..."
                      rows="2"
                      cols="8"
                      class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </textarea>
                  </div>
                </div>
              </div>
        </form>
      </ValidationObserver>
    </div>
  </div>

</template>

<script>
import LastSaved from './LastSaved.vue';
import _ from 'lodash';
import BackButton from './BackButton.vue';

  export default {
    data(){
      return{
        userStory:{
          description: "",
          priority: 1,
          value: 1,
          risk: 1,
          estimate: -1,
          acceptance: "",
          notes: "",
          category: "",
        },
        watchInPause: true,
        userStoryIndex: null,
        savingUserStory: false,
        isUserAvailable: false,
        userStoryLoaded: false,
      }
    },

    components:{LastSaved, BackButton},

    props:{
      userStoryToEditProp: Object,
      index: Number,
      epicExists:Boolean
    },

    watch:{
      userStory:{
        handler: function(){
          if(!this.watchInPause){
            this.savingUserStory = true;
            this.saveChanges();
          }
          this.watchInPause = false;
        },
        immediate:false,
        deep:true
      },

      userStoryToEditProp:{
        handler: function(){
          this.userStory = this.userStoryToEditProp;
          this.watchInPause = true;
        }
      },

      index:{
        handler: function(){
          this.userStoryIndex = this.index;
        }
      }
  },

    methods:{

      async editUserStoryFromExistingEpic(){
        try{
          const response = await axios.put('/api/auth/user-stories/' + this.userStory.id, this.userStory);
          if(response.status === 200 && response.data.success === true){
            this.watchInPause = true;
            this.userStory = response.data.userStory;
          }
        }catch(e){
          Vue.$toast.error(e);
        }finally{
          this.savingUserStory = false;
        }
      },

      async getUserStoryToEdit(userStoryId){
        try{
          const response = await axios.get('/api/auth/user-stories/' + userStoryId + '/edit');
          if(response.status === 200 && response.data.success === true){
            this.userStory = response.data.userStory;
            this.isUserAvailable = true;
            this.userStoryLoaded = true;
          }
        }catch(e){
          Vue.$toast.error(e.response.data.message);
          this.$router.push({name: 'project', params:{id: this.$route.params.projectId}});
        }
      },

      cancelNewUserStory: function(){
        if(this.epicExists === true){
          this.$router.push({name:'project', params:{id: this.$route.params.projectId}});
        }else{
          this.$emit('cancel-new-user-story');

          this.userStory = {
            description: "",
            priority: 1,
            value: 1,
            risk: 1,
            estimate: -1,
            acceptance: "",
            notes: "",
            category: "",
          } 
        }
      },

      checkForm: function(e){
        if(this.epicExists === true){
          this.editUserStoryFromExistingEpic();
        }else if(this.userStoryIndex === null){
            this.$emit('save-user-story', this.userStory);
        }else{
          let object = {
            userStory: this.userStory,
            index:this.userStoryIndex
          };
          this.$emit('edit-user-story', object);
        }
      },

      saveChanges: _.debounce(function(){
        if (!this.$refs.observer.flags.invalid){
          this.checkForm();
        }
      },2000),

      increaseButtonisDisable:function(property){
        return(this.userStory[property] >= 4);
      },

      decreaseButtonisDisable:function(property){
        return(this.userStory[property] <= 1);
      },

      increasePriority: function(){
       this.userStory.priority++;
      },

      decreasePriority: function(){
       this.userStory.priority--;
      },

      increaseRisk: function(){
       this.userStory.risk++;
      },

      decreaseRisk: function(){
       this.userStory.risk--;
      },

      increaseValue: function(){
       this.userStory.value++;
      },

      decreaseValue: function(){
       this.userStory.value--;
      },
    },

    mounted(){
      if(this.epicExists === true){
        this.getUserStoryToEdit(this.$route.params.id);
        window.onunload = () => {
          fetch('/api/auth/epics/' + this.$route.params.epicId + '/reset-status', {
              method: 'GET',
              headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${access_token}`
              },
              keepalive: true
          });
        }
      }else{
        if (Object.keys(this.userStoryToEditProp).length != 0){
          this.userStory = this.userStoryToEditProp;
          this.userStoryIndex = this.index;
       }
      }
    },

    beforeRouteLeave(to, from, next){
      if(this.isUserAvailable){
        axios.get('/api/auth/epics/' + this.$route.params.epicId + '/reset-status')
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