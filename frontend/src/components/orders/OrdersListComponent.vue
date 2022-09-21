<template>
  <q-table
    title="Pedido"
    :rows="ordersData"
    :columns="columns"
    row-key="id"
    v-model:pagination="mainPagination"
    :loading="loading"
    loading-label="Carregando..."
    no-results-label="Nenhum pedido encontrado"
    no-data-label="Nenhum pedido encontrado"
    binary-state-sort
    @request="getOrdersFunction"
  >
    <template v-slot:top-right>
      <q-btn
        icon="add"
        label="Cadastrar"
        color="primary"
        outline
        :to="{ name: 'orders_create' }"
      />
    </template>
    <template v-slot:body-cell-status="props">
      <q-td key="status" :props="props">
        <q-chip
          text-color="white"
          :label="t(`order.status.${props.row.status}`)"
          :color="props.row.status === 'pending' ? 'warning' : props.row.status === 'concluded' ? 'positive' : 'negative'"
        />
      </q-td>
    </template>
    <template v-slot:body-cell-actions="props">
      <q-td key="actions" :props="props">
        <q-btn-group outline>
          <q-btn
            outline
            color="primary"
            icon="edit"
            :to="{ name: 'orders_update', params: { 'id': props.row.id } }"
          >
            <q-tooltip>
              Editar
            </q-tooltip>
          </q-btn>
          <!--<q-btn
            outline
            color="negative"
            icon="delete"
            :loading="removing"
            :disable="removing"
            @click="destroyOrderFunction(props.row.id)"
          >
            <q-tooltip>
              Excluir
            </q-tooltip>
          </q-btn> -->
        </q-btn-group>
      </q-td>
    </template>
  </q-table>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { getOrders, destroyOrder } from 'src/services/order/order-api'
import { Notify } from 'quasar'
import { t } from 'src/services/utils/i18n'
import { formatter } from 'src/services/utils/format-currency';

let ordersData = ref([])
let loading = ref(false)
let removing = ref(false)

const mainPagination = ref({
  page: 1,
  rowsPerPage: 10,
  rowsNumber: 0,
})

const columns = [
  {
    name: 'id',
    label: 'Número',
    align: 'left',
    field: 'id',
    format: val => val || 'N/I',
  },
  {
    name: 'user',
    label: 'Usuário',
    align: 'left',
    field: 'user',
    format: val => val?.name || 'N/I',
  },
  {
    name: 'status',
    label: 'Status',
    align: 'left',
    field: 'status',
    format: val => val || 'N/I',
  },
  {
    name: 'amount',
    label: 'Total',
    align: 'left',
    field: 'amount',
    format: val => formatter(val) || 'N/I',
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
  await getOrdersFunction()
})

async function getOrdersFunction (props) {
  loading.value = true
  try {
    mainPagination.value = props?.pagination || mainPagination.value
    mainPagination.value.with = [ 'user']
    ordersData.value = await getOrders(mainPagination.value)
  } catch (e) {
    Notify.create({
      message: 'Falha ao buscar pedidos',
      type: 'negative'
    })
  }
  loading.value = false
}

/*function destroyOrderFunction (client) {
  Dialog.create({
    title: 'Atenção!',
    message: 'Tem certeza que deseja excluir este pedido?',
    cancel: true,
  }).onOk(async () => {
    removing.value = true
    try {
      await destroyOrder(client)
      getOrdersFunction()

      Notify.create({
        message: 'Usuário excluído com sucesso!',
        type: 'positive'
      })
    } catch (e) {
      Notify.create({
        message: 'Falha ao excluir pedido!',
        type: 'negative'
      })
    }
    removing.value = false
  })
}*/
</script>
