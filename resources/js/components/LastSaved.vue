<template>
  <div class="text-center">
    <p v-if="saving">Saving</p>
    <p v-else>{{savedMessage}}</p>
  </div>
</template>

<script>
import moment from 'moment';

  export default {
    data(){
      return{
        saving: false,
        time: '',
      }
    },

    props:{
      savingStatus: Boolean,
      timeInitialized: String,
    },

    watch:{
      savingStatus:{
        handler: function(){
          this.saving = this.savingStatus;
        },
      },

      timeInitialized:{
        handler: function(newTime){
          this.time = newTime;
        }
      }
    },

    computed:{
      savedMessage(){
        return `Saved: ${this.createdFromNow}`
      },

      createdFromNow(){
        return moment(this.time).fromNow();
      }
    },

    methods:{
      changeSavingStatus(){
        this.saving = !this.saving;  
      },
    },

    mounted(){
      this.time = this.timeInitialized;
    }
  }
</script>

<style scoped>

</style>