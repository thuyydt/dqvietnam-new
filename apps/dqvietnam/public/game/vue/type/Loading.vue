<template>
  <div v-if="isLoad" class="loadingio-spinner-double-ring-lqtfmr7tpk">
    <div class="ldio-3mwthuf7dsa">
      <div></div>
      <div></div>
      <div>
        <div></div>
      </div>
      <div>
        <div></div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Loading',
  props: ['isLoad'],
  data() {
    return {
      isLoading: false
    }
  },
  watch: {
    isLoad: {
      handler(value) {
        this.isLoading = value;
      }
    }
  }
}
</script>
