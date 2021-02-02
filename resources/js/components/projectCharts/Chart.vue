<script>
import {Bar} from 'vue-chartjs';

export default {
  extends: Bar,
  data(){
    return{
      chartdata: {
        labels: null,
        datasets:[
          {
            label: this.projectName,
            backgroundColor: this.backGroundColorProp,
            borderColor: this.borderColorProp,
            borderWidth:1,
            data: null,
            barPercentage: 6,
            barThickness: 15,
            maxBarThickness: 20,
            minBarLength: 2,
          },
        ]
      },
      options:{
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          yAxes: [{
              ticks: {
                  precision: 0,
                  beginAtZero: true
              }
          }],
        },
        
      }
    }
  },

  props: {
    chartDataProp:{
      type: Array,
      default: null
    },
    chartLabels:{
      type: Array,
      default: null
    },
    backGroundColorProp: String,
    borderColorProp: String,
    chartInfo: String,
    projectName: String
  },

  methods:{
    setChartData: function(dataSets, chartInfo){
      let data = [0,0,0,0];

      dataSets.forEach(function(element){ 
        switch(element[chartInfo]){
          case 1:
            data[0] = element.count;
            break;
          
          case 2:
            data[1] = element.count;
            break;
          
          case 3:
            data[2] = element.count;
            break;
          
          case 4:
            data[3] = element.count;
            break;
        }
      });
      return data;
    }
  },

  mounted(){
    this.chartdata.datasets[0].data = this.setChartData(this.chartDataProp, this.chartInfo);
    this.chartdata.labels = this.chartLabels;
    this.renderChart(this.chartdata, this.options)
  }    
}
</script>

<style scoped>

</style>