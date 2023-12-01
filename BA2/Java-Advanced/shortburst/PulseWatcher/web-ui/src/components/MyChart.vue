<script setup lang="ts">
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend, ChartData
} from 'chart.js'
import { Line } from 'vue-chartjs'
import {PropType} from "vue";

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
)

const props = defineProps(
    {
      data: {
        type: Object as PropType<ChartData<'line'>>,
        required: true
      },
    }
)
const options = {
  responsive: true,
  maintainAspectRatio: false
}

</script>

<template>
  <div style="height: 250px; max-width: 800px">
    <Line :data="props.data" :options="options" />
  </div>
</template>

<style scoped>

</style>