<template>
  <div class="go-back md:absolute">
    <span>
      <button @click="goBack"><i class="fa fa-arrow-circle-left back-icon"></i></button>
    </span>
  </div>
</template>

<script>
  export default {
    methods:{
      goBack: function(){
        return this.$router.go(-1);
      },
    },
  }
</script>

<style scoped>
  .go-back{
    left: 0rem;
    margin-left: 24px;
    cursor: pointer;
  }

  .back-icon{
    font-size: 1.5rem;
  }

  button{
    border:0;
  }
</style>