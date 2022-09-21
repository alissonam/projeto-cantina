import { loggedUser } from '../boot/user'

const redirectToDashboardIfLogged = (to, from, next) => {
  if (localStorage.getItem('isUserLogged')) {
    next('/')
  } else {
    next()
  }
}

const redirectToLoginIfNotLogged = (to, from, next) => {
  if (localStorage.getItem('isUserLogged')) {
    next()
  } else {
    next('/login')
  }
}

const checkPermission = (to, from, next) => {
  if (loggedUser.permission?.abilities?.includes(to.meta.permission)) {
    next()
  } else {
    next('/')
  }
}

const permissions = [
  {
    path: '/permissions',
    name: 'permissions',
    component: () => import('pages/Permissions/PermissionsList'),
    beforeEnter: checkPermission,
    meta: { permission: 'permissions' }
  },
  {
    path: '/permissions/create',
    name: 'permissions_create',
    component: () => import('pages/Permissions/PermissionsForm'),
    beforeEnter: checkPermission,
    meta: { permission: 'permissions' }
  },
  {
    path: '/permissions/update/:id',
    name: 'permissions_update',
    component: () => import('pages/Permissions/PermissionsForm'),
    beforeEnter: checkPermission,
    meta: { permission: 'permissions' }
  }
]

const users = [
  {
    path: '/users',
    name: 'users',
    component: () => import('pages/Users/UsersList'),
    beforeEnter: checkPermission,
    meta: { permission: 'users' }
  },
  {
    path: '/users/create',
    name: 'users_create',
    component: () => import('pages/Users/UsersForm'),
    beforeEnter: checkPermission,
    meta: { permission: 'users' }
  },
  {
    path: '/users/update/:id',
    name: 'users_update',
    component: () => import('pages/Users/UsersForm'),
    beforeEnter: checkPermission,
    meta: { permission: 'users' }
  }
]

const products = [
  {
    path: '/products',
    name: 'products',
    component: () => import('pages/Products/ProductsList'),
    beforeEnter: checkPermission,
    meta: { permission: 'products' }
  },
  {
    path: '/products/create',
    name: 'products_create',
    component: () => import('pages/Products/ProductsForm'),
    beforeEnter: checkPermission,
    meta: { permission: 'products' }
  },
  {
    path: '/products/update/:id',
    name: 'products_update',
    component: () => import('pages/Products/ProductsForm'),
    beforeEnter: checkPermission,
    meta: { permission: 'products' }
  }
]

const orders = [
  {
    path: '/orders',
    name: 'orders',
    component: () => import('pages/Orders/OrdersList'),
    beforeEnter: checkPermission,
    meta: { permission: 'orders' }
  },
  {
    path: '/orders/create',
    name: 'orders_create',
    component: () => import('pages/Orders/OrdersForm'),
    beforeEnter: checkPermission,
    meta: { permission: 'orders' }
  },
  {
    path: '/orders/update/:id',
    name: 'orders_update',
    component: () => import('pages/Orders/OrdersForm'),
    beforeEnter: checkPermission,
    meta: { permission: 'orders' }
  }
]

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout'),
    beforeEnter: redirectToLoginIfNotLogged,
    children: [
      {
        path: '',
        name: 'home',
        redirect: '/dashboard'
      },
      {
        path: 'dashboard',
        name: 'dashboard',
        component: () => import('pages/Index')
      },
      ...permissions,
      ...users,
      ...products,
      ...orders,
    ]
  },
  {
    path: '/login',
    name: 'login',
    beforeEnter: redirectToDashboardIfLogged,
    component: () => import('pages/Login/PageLogin')
  },
  {
    path: '/reset-password/:token',
    name: 'reset_password',
    beforeEnter: redirectToDashboardIfLogged,
    component: () => import('pages/Login/ResetPasswordPage')
  },
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404')
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('pages/Register/PageRegisterUser')
  }
]

export default routes
