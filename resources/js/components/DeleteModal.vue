<template id="modal-template">
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          
            <div class="modal-header">
                <h2>{{title}}</h2>
                <button class="button" @click="$emit('close-delete-modal')">X</button>
            </div>


            <div class="modal-body">
                <p>{{this.message}}</p>      
            </div>

            <div class="modal-footer flex justify-around">
                <button @click="$emit('close-delete-modal')" class="basicButton">{{leftButton}}</button>
                <button @click="$emit('delete-project')" class="basicButton">{{rightButton}}</button>
            </div>
          
        </div>
      </div>
    </div>
  </transition>
</template>


<script>
export default {
  data(){
    return{
      
    }
  },

  props:{
    title: String,
    message: String,
    leftButton: String,
    rightButton: String,
  },

}
</script>