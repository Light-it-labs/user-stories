<template>
  <div class="text-center">
    <p v-if="saving">Saving</p>
    <p v-else>{{savedMessage}}</p>
  </div>
</template>

<script>
  export default {
    data(){
      return{
        saving: false,
        hours: '',
        minutes: '',
        seconds: ''
      }
    },

    props:{
      savingStatus: Boolean,
    },

    watch:{
      savingStatus:{
        handler: function(){
          this.changeSavingStatus();
        },
      },
    },

    computed:{
      savedMessage(){
        return `Last time saved: ${this.hours}:${this.minutes}:${this.seconds}`;
      },
    },

    methods:{
      changeSavingStatus(){
        this.saving = !this.saving;  
      },

      formatDateTimeNumber(number){
        const formatedNumber = ("00" + number).slice(-2);
        return formatedNumber;
      },

      updateTime(){
        const dateInstance = new Date();
        this.minutes = this.formatDateTimeNumber(dateInstance.getMinutes());
        this.hours = this.formatDateTimeNumber(dateInstance.getHours());
        this.seconds = this.formatDateTimeNumber(dateInstance.getSeconds());
      }
    }
  }
</script>

<style scoped>

</style>