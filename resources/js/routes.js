import Vue from "vue";
import VueRouter from 'vue-router';
import UserStoryForm from './components/UserStoryForm.vue';
import Project from './components/Project.vue';
import ProjectIndex from './components/ProjectIndex.vue';
import EpicEditor from './components/EpicEditor.vue';
import ProjectForm from './components/ProjectForm.vue';
import ProjectDashboard from './components/ProjectDashboard.vue';
import InviteUserForm from './components/InviteUserForm.vue';

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
            path:'/projects/:id/invite',
            name:'invite-to-project',
            component: InviteUserForm,
            props:{
                buttonText: 'Invite'
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

 router.beforeEach((to, from, next) => {
    const user = JSON.parse(localStorage.getItem("user"));
    const acces_token = JSON.parse(localStorage.getItem("access_token"));
     
    if((to.path !== "/login" && to.path !== "/signup" && to.path !== "/invitation/signup") && (!user && !acces_token)){
        window.location.href = '/login';
    }else{
         next();
    }
});

export default router;