<template>
  <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <h2 class="mb-4 text-center font-extrabold text-gray-600">Project Invitation</h2>
        <p class="text-base">Hi <span class="font-bold">{{invitation.email}}</span>!</p>
        <p class="text-base my-2"><span class="font-bold">{{invitation.invitation_owner}}</span> has invited to join and contibute in a project</p>

        <div class="flex justify-center">
          <button @click="acceptInvitation()" class="basicButton my-4">Accept Invitation</button>
        </div>
        
        <p class="text-xs">This invitation will expire in 5 hours</p>
      </div>
  </div>
</template>

<script>
  export default {
    data(){
      return{
        invitation:{
          email: this.$route.query.email,
          expires: this.$route.query.expires,
          invitation_owner: this.$route.query.invitation_owner,
          project_id: this.$route.query.project_id,
          signature: this.$route.query.signature,
          token: this.$route.query.token
        }
        
      }
    },

    methods:{
      async acceptInvitation(){
        const response = await axios.post('/api/auth/users/invitation',this.invitation);
        if(response.status === 200 && response.data.success === true){
          Vue.$toast.success(response.data.message);
          window.location.href = '/login';
        }
        
      }
    },
  }
</script>

<style scoped>

</style>