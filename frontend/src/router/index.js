import { createRouter, createWebHistory } from 'vue-router';
import Clientes from '../views/ClientesView.vue';
import Agenda from '../views/AgendaView.vue';
import Pets from '../views/AnimaisView.vue';

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
  {
    path: '/pets',
    name: 'Pets',
    component: Pets
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
