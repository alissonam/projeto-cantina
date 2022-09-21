import { get, post, put, destroy } from 'boot/axios'

export const getItems = async (params = { page: '', rowsPerPage: 0 }) => {
  params.perPage = params.rowsPerPage || 0
  const { data } = await get('/items', params)
  params.rowsNumber = data.total
  return data.data
}

export const getItem = async (id, params) => {
  const { data } = await get(`/items/${id}`, params)
  return data
}

export const createItem = async item => {
  const { data } = await post('/items', item)
  return data
}

export const updateItem = async (id, item) => {
  const { data } = await put(`/items/${id}`, item)
  return data
}

export const destroyItem = async id => {
  await destroy(`/items/${id}`)
}
