<template>
  <q-btn
    color="primary"
    icon="arrow_back"
    dense
    outline
    rounded
    :to="{ name: 'orders' }"
  >
    <q-tooltip :offset="[5, 5]">
      Voltar
    </q-tooltip>
  </q-btn>
  <h4 class="q-mt-lg" v-if="!route.params.id">Criar pedido</h4>
  <h4 class="q-mt-lg" v-else>Editar pedido</h4>
  <q-form
    ref="orderForm"
    @submit="submitOrder()"
  >
    <div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-py-xs q-mr-md">
          <q-select
            label="Usuário"
            v-model="order.user_id"
            map-options
            emit-value
            hide-bottom-space
            clearable
            :options="usersOptions"
            :option-label="opt => opt.name || order.user?.name || 'N/I'"
            option-value="id"
            dense
            outlined
            :loading="loadingUsers"
            :rules="[val => !!val || 'Preenchimento obrigatório']"
            @filter="filterUsers"
          />
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-py-xs q-mr-md">
          <q-input
            v-model="order.amount"
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
          <q-select
            v-model="order.status"
            label="Status"
            hide-bottom-space
            dense
            outlined
            map-options
            emit-value
            :options="statusOptions"
            :option-label="opt => opt.label || t(`order.status.${order.status}`)"
            :rules="[val => !!val || 'Preenchimento obrigatório']"
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
import { createOrder, updateOrder, getOrder } from 'src/services/order/order-api'
import { getUsers } from 'src/services/user/user-api'
import { Notify, Loading } from 'quasar'
import { formatResponseError } from "src/services/utils/error-formatter";
import { t } from 'src/services/utils/i18n'

const router = useRouter()
const route = useRoute()
let order = ref({})
let saving = ref(false)
const orderForm = ref(null)
let usersOptions = ref([])
let loadingUsers = ref(false)

let statusOptions = [
  {
    label: 'Pendente',
    value: 'pending',
  },
  {
    label: 'Finalizado',
    value: 'concluded',
  },
  {
    label: 'Cancelado',
    value: 'canceled',
  }
]

onMounted(async () => {
  if (route.params.id) {
    await getOrderFunction()
  }
})

async function submitOrder() {
  saving.value = true
  try {
    const validated = orderForm.value.validate()
    if (validated) {
      const orderToSave = { ...order.value }
      orderToSave.amount = parseFloat(orderToSave.amount.replace(",", "."))
      !route.params.id ? await createOrder(orderToSave) : await updateOrder(route.params.id, orderToSave)

      Notify.create({
        message: !route.params.id ? 'Pedido criado com sucesso!' : 'Pedido editado com sucesso!',
        type: 'positive'
      })

      router.push({ name: 'orders' })
    }
  } catch (error) {
    Notify.create({
      message: formatResponseError(error) || 'Falha ao salvar pedido',
      type: 'negative'
    })
  }
  saving.value = false
}

async function getOrderFunction() {
  Loading.show()
  try {
    const response = await getOrder(route.params.id)
    order.value = response
  } catch (e) {
    Notify.create({
      message: 'Falha ao buscar pedido!',
      type: 'negative'
    })
  }
  Loading.hide()
}

async function filterUsers(val, update, abort) {
  loadingUsers.value = true
  try {
    const result = await getUsers({
      name: val,
      rowsPerPage: 25,
    })
    usersOptions.value = result
    update()
  } catch (e) {
    Notify.create({
      message: 'Falha ao buscar permissões!',
      type: 'negative'
    })
    abort()
  }
  loadingUsers.value = false
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
