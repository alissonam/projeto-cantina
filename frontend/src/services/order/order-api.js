import { get, post, put, destroy } from 'boot/axios'

export const getOrders = async (params = { page: '', rowsPerPage: 0 }) => {
  params.perPage = params.rowsPerPage || 0
  const { data } = await get('/orders', params)
  params.rowsNumber = data.total
  return data.data
}

export const getOrder = async (id, params) => {
  const { data } = await get(`/orders/${id}`, params)
  return data
}

export const createOrder = async order => {
  const { data } = await post('/orders', order)
  return data
}

export const updateOrder = async (id, order) => {
  const { data } = await put(`/orders/${id}`, order)
  return data
}

export const destroyOrder = async id => {
  await destroy(`/orders/${id}`)
}
