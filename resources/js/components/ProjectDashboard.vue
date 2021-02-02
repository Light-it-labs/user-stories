<template>
  <div v-if="projectLoaded">
    <h1>{{project.name}}</h1>

    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
      <div class="col-span-6 md:col-span-2">
        <div class="dashboard-info-box flex justify-between">
          <h3>Total Epics: </h3>
          <h3>{{project.epics.length}}</h3>
        </div>
        <div class="dashboard-info-box flex justify-between">
          <h3>Total User Stories: </h3>
          <h3>{{userStoriesCount}}</h3>
        </div>
        <div class="dashboard-info-box flex justify-between">
          <h3>Created: </h3>
          <h3>{{parseDate(project.created_at)}}</h3>
        </div>
        <div class="dashboard-info-box flex justify-between">
          <h3>Last Update: </h3>
          <h3>{{parseDate(project.updated_at)}}</h3>
        </div>
      </div>

      <div class="col-span-6 md:col-span-4 dashboard-box">
        <h2 class="mb-1">Strategic User Stories</h2>
        <ul>
          <li class="text-sm" v-for="(description, index) in strategicUserStoriesDescription" :key="index">{{description}}</li>
        </ul>
      </div>
      
      <div class="col-span-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="dashboard-box" v-if="charts.priorityChart.loaded">
          <h2>User Story - Priority</h2>
          <Chart
            :chartDataProp="charts.priorityChart.data"
            :projectName="project.name"
            :chartLabels="charts.priorityChart.labels"
            :chartInfo="'priority'"
            :backGroundColorProp="'rgb(221,242,242)'"
            :borderColorProp="'rgb(76,192,192)'"
          >
          </Chart>
        </div>

        <div class="dashboard-box" v-if="charts.valueChart.loaded">
          <h2>User Story - Value</h2>
          <Chart
            :chartDataProp="charts.valueChart.data"
            :projectName="project.name"
            :chartLabels="charts.valueChart.labels"
            :chartInfo="'value'"
            :backGroundColorProp="'rgb(255,236,219)'"
            :borderColorProp="'rgb(255,159,65)'"
          >
          </Chart>
        </div>

        <div class="dashboard-box" v-if="charts.riskChart.loaded">
          <h2>User Story - Risk</h2>
          <Chart
            :chartDataProp="charts.riskChart.data"
            :projectName="project.name"
            :chartLabels="charts.riskChart.labels"
            :chartInfo="'risk'"
            :backGroundColorProp="'rgb(255,225,230)'"
            :borderColorProp="'rgb(255,99,132)'"
          >
          </Chart>
        </div>
      </div>
    </div>
    
  </div>
</template>

<script>
import Chart from './projectCharts/Chart.vue';
import moment from 'moment';

  export default {
    data(){
      return{
        project:{},
        strategicUserStoriesDescription:[],
        userStoriesCount: null,
        charts: {

          priorityChart:{
            data: null,
            labels: ['1','2','3','4'],
            loaded: false
          },
          
          valueChart: {
            data: null,
            labels: ['1','2','3','4'],
            loaded: false
          },

          riskChart: {
            data: null,
            labels: ['1','2','3','4'],
            loaded: false
          }
        },
        projectLoaded: false
      }
    },

    components:{Chart},

    methods:{

      async getProject(projectId){
        try{
          const response = await axios.get('/api/auth/projects/' + projectId);
          if(response.status === 200 && response.data.success === true){
            this.project = response.data.project;
            this.projectLoaded = true;
          }
        }catch(e){
          Vue.$toast.error(e);
        }
      },

      async getPriorityChartData(projectId){
        try{
          const response = await axios.get('/api/auth/projects/' + projectId + '/dashboard/user-story-priority');
          if(response.status === 200 && response.data.success === true){
            this.charts.priorityChart.data = response.data.chartData.dataSets;
            this.charts.priorityChart.loaded = true;
          }
        }catch(e){
          Vue.$toast.error(e);
        }
      },

      async getValueChartData(projectId){
        try{
          const response = await axios.get('/api/auth/projects/' + projectId + '/dashboard/user-story-value');
          if(response.status === 200 && response.data.success === true){
            this.charts.valueChart.data = response.data.chartData.dataSets;
            this.charts.valueChart.loaded = true;
          }
        }catch(e){
          Vue.$toast.error(e);
        }
      },

      async getRiskChartData(projectId){
        try{
          const response = await axios.get('/api/auth/projects/' + projectId + '/dashboard/user-story-risk');
          if(response.status === 200 && response.data.success === true){
            this.charts.riskChart.data = response.data.chartData.dataSets;
            this.charts.riskChart.loaded = true;
          }
        }catch(e){
          Vue.$toast.error(e);
        }
      },

      async getStrategicUserStoriesDescription(projectId){
        try{
          const response = await axios.get('/api/auth/projects/' + projectId + '/dashboard/strategic-user-stories');
          if(response.status === 200 && response.data.success === true){
            this.strategicUserStoriesDescription = response.data.userStoriesDescription;
          }
        }catch(e){
          Vue.$toast.error(e);
        }
      },

      async getProjectUserStoriesCount(projectId){
        try{
          const response = await axios.get('/api/auth/projects/' + projectId + '/dashboard/user-stories-count');
          if(response.status === 200 && response.data.success === true){
            this.userStoriesCount = response.data.userStoriesCount;
          }
        }catch(e){
          Vue.$toast.error(e);
        }
      },

      parseDate: function(date){
        return moment(date).format('DD-MMM-YYYY');
      }
    },

    mounted(){
      const access_token = JSON.parse(localStorage.access_token);
      axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`;
      this.getProject(this.$route.params.id);
      this.getPriorityChartData(this.$route.params.id);
      this.getValueChartData(this.$route.params.id);
      this.getRiskChartData(this.$route.params.id);
      this.getStrategicUserStoriesDescription(this.$route.params.id);
      this.getProjectUserStoriesCount(this.$route.params.id);
      
      

    }
  }
</script>

<style scoped>

</style>