<template>
  <div class="bg-gray-700 px-5 py-2 mb-4">
    <nav class="flex justify-between">
      
      <a href="/projects" class="navBarButton">Home</a>
      <div class="flex justify-end">
        <Burger
          @toggle-nav="toggleNav"
          :isNavOpenProp="isNavOpen"
        >
        </Burger>
        <SideBar
          @toggle-nav="toggleNav"
          :isNavOpenProp="isNavOpen"
        >
          <ul v-if="isUserLoggedIn" class="sidebar-panel-nav">
            <li @click="toggleNav"><a href="/projects" class="navBarButton">Projects</a></li>
            <li @click="toggleNav"><a href="/projects/create" class="navBarButton">Create Project</a></li>
            <li @click="toggleNav"><a href="/password/reset" class="navBarButton">Change Password</a></li>
            <li @click="logOutUser()"><button class="navBarButton">LogOut</button></li>
          </ul>
          <ul v-else class="sidebar-panel-nav">
            <li @click="toggleNav"><a href="/login" class="navBarButton">LogIn</a></li>
            <li @click="toggleNav"><a href="/signup" class="navBarButton">SignUp</a></li>
          </ul>
        </SideBar>

      </div>
      
    </nav>
  </div>
</template>

<script>
import Burger from './BurgerMenu.vue';
import SideBar from './SideBar.vue';
  export default {
    data(){
      return{
        isNavOpen: false,
        isUserLoggedIn: false
      }
    },

    components:{Burger, SideBar},

    methods:{

      toggleNav(){
        this.isNavOpen = !this.isNavOpen;
      },

      async logOutUser(){
        try{
          const response = await axios.get('/api/auth/logout');
          if(response.status === 200 && response.data.success === true){
            localStorage.removeItem('user');
            localStorage.removeItem('access_token');
            Vue.$toast.success(response.data.message);
            this.toggleNav();
            window.location.href = '/';
          }
        }catch(e){
          Vue.$toast.error(e.response.data.message);
        }
      },
    },

    mounted(){
      const user = JSON.parse(localStorage.getItem("user"));
      if(user){
        this.isUserLoggedIn = true;
      }
    }
    
  }
</script>

<style scoped>
ul.sidebar-panel-nav {
   list-style-type: none;
 }
</style>