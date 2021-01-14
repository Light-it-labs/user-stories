import Vue from "vue";
import VueRouter from 'vue-router';
import UserStoryForm from './components/UserStoryForm.vue';
import Project from './components/Project.vue';
import ProjectIndex from './components/ProjectIndex.vue';
import EpicEditor from './components/EpicEditor.vue';
import ProjectForm from './components/ProjectForm.vue';

Vue.use(VueRouter);

export default new VueRouter({
    mode: "history",

    routes: [

        {
            path: '/projects/:projectId/epics/:id',
            name: 'Epic',
            component: EpicEditor,
            props: true
        },

        {
          path:'/projects',
          name: 'Projects',
          component: ProjectIndex,
          props:true  
        },

        {
            path:'/projects/:id',
            name: 'Project',
            component: Project,
            props:true
        },

        {
            path:'/projects/create',
            name: 'Create-Project',
            component: ProjectForm,
            props: {
                title: 'Create New Project',
                buttonText: 'Create',
                isNew:true,
            },
        },

        {
            path:'/projects/:id/edit',
            name:'Edit-Project',
            component:ProjectForm,
            props:{
                title: 'Edit Project',
                buttonText: 'Save',
                isNew: false,
            }
        },

        {
            path: '/projects/:projectId/epic/:epicId/user-story/:id',
            name: 'UserStory',
            component: UserStoryForm,
            props: {
                epicExists: true
            }
        }
        
    ]
})