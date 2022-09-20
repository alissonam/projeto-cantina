<template>
  <div class="full-width q-pa-lg items-start">
    <q-card>
      <q-card-section>
        <products-form />
      </q-card-section>
    </q-card>
  </div>
</template>

<script setup>
import ProductsForm from '../../components/products/ProductsFormComponent.vue'
</script>

<style scoped>
  .full-width {
    width: 100%;
  }
</style>
