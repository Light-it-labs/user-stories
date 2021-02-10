import Vue from "vue";
import VueRouter from 'vue-router';
import UserStoryForm from './components/UserStoryForm.vue';
import Project from './components/Project.vue';
import ProjectIndex from './components/ProjectIndex.vue';
import EpicEditor from './components/EpicEditor.vue';
import ProjectForm from './components/ProjectForm.vue';
import ProjectDashboard from './components/ProjectDashboard.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",

    routes: [

        {
            path: '/projects/:projectId/epics/:id',
            name: 'epic',
            component: EpicEditor,
            props: true
        },

        {
          path:'/projects',
          name: 'projects',
          component: ProjectIndex,
          props:true  
        },

        {
            path:'/projects/create',
            name: 'create-project',
            component: ProjectForm,
            props: {
                title: 'Create New Project',
                buttonText: 'Create',
                isNew:true,
            },
        },

        {
            path:'/projects/:id',
            name: 'project',
            component: Project,
            props:true
        },

        {
            path:'/projects/:id/edit',
            name:'edit-project',
            component: ProjectForm,
            props:{
                title: 'Edit Project',
                buttonText: 'Save',
                isNew: false,
            }
        },

        {
            path:'/projects/:id/dashboard',
            name:'project-dashboard',
            component: ProjectDashboard,
            props: true,
        },

        {
            path: '/projects/:projectId/epic/:epicId/user-story/:id',
            name: 'user-story',
            component: UserStoryForm,
            props: {
                epicExists: true
            }
        }
        
    ]
});

 router.beforeEach(async(to, from, next) => {
     await Vue.nextTick();
     if((to.path !== "/login" && to.path !== "/signup") && !router.app.$root.isAuthenticated){
        window.location.href = '/login';
     }else{
         next();
     }
});

export default router;