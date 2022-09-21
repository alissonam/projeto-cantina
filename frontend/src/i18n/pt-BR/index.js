// This is just an example,
// so you can safely delete all default props below

export default {
  user: {
    role: {
      admin: 'Administrador',
      member: 'Membro',
    },
    status: {
      pending_password: 'Pendente de senha',
      active: 'Ativo',
      blocked: 'Bloqueado',
      blocked_by_time: 'Bloqueado por tempo',
    }
  },
  permissions: {
    users: 'Usuários',
    permissions:'Permissões',
    products: 'Produtos',
    orders: 'Pedidos',
    items: 'Items'
  },
  order: {
    status: {
      canceled: 'Cancelado',
      pending: 'Pendente',
      concluded: 'Finalizado'
    }
  },
  categories: {
    create_user: 'Criação de Usuário',
    printer: 'Impressora',
    hardware: 'Hardware',
    software: 'Software',
    network: 'Rede',
  },
}
