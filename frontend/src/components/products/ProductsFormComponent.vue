<template>
  <q-btn
    color="primary"
    icon="arrow_back"
    dense
    outline
    rounded
    :to="{ name: 'products' }"
  >
    <q-tooltip :offset="[5, 5]">
      Voltar
    </q-tooltip>
  </q-btn>
  <h4 class="q-mt-lg" v-if="!route.params.id">Criar produto</h4>
  <h4 class="q-mt-lg" v-else>Editar produto</h4>
  <q-form
    ref="productForm"
    @submit="submitProduct()"
  >
    <div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-py-xs q-mr-md">
          <q-input
            label="Nome"
            v-model="product.name"
            hide-bottom-space
            dense
            outlined
            :rules="[val => !!val || 'Preenchimento obrigatório']"
          />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-py-xs q-mr-md">
          <q-input
            v-model="product.price"
            dense
            prefix="R$"
            mask="#,##"
            fill-mask="0"
            reverse-fill-mask
            label="Valor unitário"
            outlined
            lazy-rules
            :rules="[ val => !isNaN(parseFloat(val)) || 'Preenchimento obrigatório',
                    val => !parseFloat(val) <= 0 || 'O valor deve ser maior que zero'
            ]"
          />
        </div>
        <div class="col">
          <q-input
            v-model="product.quantity"
            dense
            fill-mask="0"
            label="Quantidade"
            outlined
            lazy-rules
            :rules="[ val => !isNaN(parseFloat(val)) || 'Preenchimento obrigatório',
                    val => !parseFloat(val) <= 0 || 'O valor deve ser maior que zero'
            ]"
          />
        </div>
      </div>
      <div class="row">
        <div class="col q-mb-lg">
          <q-input
            label="Descrição"
            v-model="product.description"
            dense
            outlined
          />
        </div>
      </div>
    </div>
    <div align="right">
      <q-btn
        outline
        label="Salvar"
        icon="save"
        type="submit"
        color="primary"
        :disable="saving"
        :loading="saving"
      />
    </div>
  </q-form>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { createProduct, updateProduct, getProduct } from 'src/services/product/product-api'
import { Notify, Loading } from 'quasar'
import { formatResponseError } from "src/services/utils/error-formatter";

const router = useRouter()
const route = useRoute()
let product = ref({})
let saving = ref(false)
const productForm = ref(null)

onMounted(async () => {
  if (route.params.id) {
    await getProductFunction()
  }
})

async function submitProduct() {
  saving.value = true
  try {
    const validated = productForm.value.validate()
    if (validated) {
      const productToSave = { ...product.value }
      productToSave.price = parseFloat(productToSave.price.replace(",", "."))
      !route.params.id ? await createProduct(productToSave) : await updateProduct(route.params.id, productToSave)

      Notify.create({
        message: !route.params.id ? 'Produto criado com sucesso!' : 'Produto editado com sucesso!',
        type: 'positive'
      })

      router.push({ name: 'products' })
    }
  } catch (error) {
    Notify.create({
      message: formatResponseError(error) || 'Falha ao salvar produto',
      type: 'negative'
    })
  }
  saving.value = false
}

async function getProductFunction() {
  Loading.show()
  try {
    const response = await getProduct(route.params.id)
    product.value = response
  } catch (e) {
    Notify.create({
      message: 'Falha ao buscar produto!',
      type: 'negative'
    })
  }
  Loading.hide()
}
</script>

<style scoped>
  .q-date__content {
    width: auto;
    min-width: 200px;
  }

  .q-date {
    width: auto;
    min-width: 200px;
  }

  .q-time__content {
    width: auto;
    min-width: 200px;
  }

  .q-time {
    width: 440px;
    min-width: 200px;
  }
</style>
