<template>
  <div class="full-width q-pa-lg items-start">
    <q-card>
      <q-card-section>
        <orders-form />
      </q-card-section>
    </q-card>
  </div>
</template>

<script setup>
import OrdersForm from '../../components/orders/OrdersFormComponent.vue'
</script>

<style scoped>
  .full-width {
    width: 100%;
  }
</style>
