import { createRouter, createWebHistory } from 'vue-router'
import Clientes from '../views/ClientesView.vue'
import Agenda from '../views/AgendaView.vue'

const routes = [
  {
    path: '/clientes',
    name: 'Clientes',
    component: Clientes
  },
  {
    path: '/',
    name: 'Agenda',
    component: Agenda
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
