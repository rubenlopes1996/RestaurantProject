<script>
import { Line, mixins } from 'vue-chartjs'
import zoom from 'chartjs-plugin-zoom'
const { reactiveProp } = mixins

export default {
  extends: Line,
  mixins: [reactiveProp],
  props: ['options'],
  mounted () {
    // this.chartData is created in the mixin.
    // If you want to pass options please create a local options object
    this.addPlugin(zoom),
    this.renderChart(this.chartData, this.options)
  }
}
</script>
<style>
</style>