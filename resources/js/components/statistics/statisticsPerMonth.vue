
<template>
    
</template>

<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: ['chartdata', 'options'],
  mounted () {
    this.renderChart(this.chartdata, this.options)
  }, methods: {
      //total number of meals per month

      //orders handled per month

      /*average time it takes to handle each meal (time between the moment a meal is created 
      until the meal is closed – “paid” or “not paid”)*/
  
     /*the average time it takes to handle
    each order (time between the moment an order is created until the order is closed –
    “delivered” or “not delivered”) organized by item of the restaurant’s menu (i.e. for each
    month the average time to handle each of the items in the menu) */
  },
}
</script>

<style>
</style>