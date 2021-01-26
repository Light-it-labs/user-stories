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
            path: '/projects/:projectId/epic/:epicId/user-story/:id',
            name: 'user-story',
            component: UserStoryForm,
            props: {
                epicExists: true
            }
        }
        
    ]
})