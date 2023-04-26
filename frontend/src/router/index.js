import { createRouter, createWebHistory } from 'vue-router'
import Clientes from '../views/ClientesView.vue'

const routes = [
  {
    path: '/clientes',
    name: 'Clientes',
    component: Clientes
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
