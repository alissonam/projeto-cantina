<template>
  <q-table
    title="Produtos"
    :rows="productsData"
    :columns="columns"
    row-key="id"
    v-model:pagination="mainPagination"
    :loading="loading"
    loading-label="Carregando..."
    no-results-label="Nenhum produto encontrado"
    no-data-label="Nenhum produto encontrado"
    binary-state-sort
    @request="getProductsFunction"
  >
    <template v-slot:top-right>
      <q-btn
        icon="add"
        label="Cadastrar"
        color="primary"
        outline
        :to="{ name: 'products_create' }"
      />
    </template>
    <template v-slot:body-cell-actions="props">
      <q-td key="actions" :props="props">
        <q-btn-group outline>
          <q-btn
            outline
            color="primary"
            icon="edit"
            :to="{ name: 'products_update', params: { 'id': props.row.id } }"
          >
            <q-tooltip>
              Editar
            </q-tooltip>
          </q-btn>
          <q-btn
            outline
            color="negative"
            icon="delete"
            :loading="removing"
            :disable="removing"
            @click="destroyProductFunction(props.row.id)"
          >
            <q-tooltip>
              Excluir
            </q-tooltip>
          </q-btn>
        </q-btn-group>
      </q-td>
    </template>
  </q-table>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { getProducts, destroyProduct } from 'src/services/product/product-api'
import { Notify, Dialog } from 'quasar'
import { formatter } from "src/services/utils/format-currency";

let productsData = ref([])
let loading = ref(false)
let removing = ref(false)

const mainPagination = ref({
  page: 1,
  rowsPerPage: 10,
  rowsNumber: 0,
})

const columns = [
  {
    name: 'name',
    label: 'Nome',
    align: 'left',
    field: 'name',
    format: val => val || 'N/I',
  },
  {
    name: 'price',
    label: 'Preço Unitário',
    align: 'center',
    field: 'price',
    format: val => formatter(val) || 'N/I',
  },
  {
    name: 'quantity',
    label: 'Quantidade Disponivel',
    align: 'left',
    field: 'quantity',
    format: val => val || 'N/I',
  },
  {
    name: 'description',
    label: 'Descrição',
    align: 'left',
    field: 'description',
    format: val => val || 'N/I',
  },
  {
    name: 'actions',
    align: 'center',
    label: 'Ações',
    field: 'id',
    sortable: false
  },
]

onMounted(async () => {
  await getProductsFunction()
})

async function getProductsFunction (props) {
  loading.value = true
  try {
    mainPagination.value = props?.pagination || mainPagination.value
    productsData.value = await getProducts(mainPagination.value)
  } catch (e) {
    Notify.create({
      message: 'Falha ao buscar produtos',
      type: 'negative'
    })
  }
  loading.value = false
}

function destroyProductFunction (client) {
  Dialog.create({
    title: 'Atenção!',
    message: 'Tem certeza que deseja excluir este produto?',
    cancel: true,
  }).onOk(async () => {
    removing.value = true
    try {
      await destroyProduct(client)
      getProductsFunction()

      Notify.create({
        message: 'Usuário excluído com sucesso!',
        type: 'positive'
      })
    } catch (e) {
      Notify.create({
        message: 'Falha ao excluir produto!',
        type: 'negative'
      })
    }
    removing.value = false
  })
}
</script>
