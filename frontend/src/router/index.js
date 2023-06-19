import { createRouter, createWebHistory } from 'vue-router';
import Clientes from '../views/ClientesView.vue';
import Agenda from '../views/AgendaView.vue';
import Pets from '../views/AnimaisView.vue';
import Estoque from '../views/EstoqueView.vue';
import Caixa from '../views/CaixaView.vue';
import Funcionarios from '../views/FuncionariosView.vue';
import Login from '../views/LoginView.vue';

const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login,
    meta: {
      mostrarNavbar: false
    }
  },
  {
    path: '/clientes',
    name: 'Clientes',
    component: Clientes
  },
  {
    path: '/agenda',
    name: 'Agenda',
    component: Agenda
  },
  {
    path: '/pets',
    name: 'Pets',
    component: Pets
  },
  {
    path: '/estoque',
    name: 'Estoque',
    component: Estoque
  },
  {
    path: '/caixa',
    name: 'Caixa',
    component: Caixa
  },
  {
    path: '/funcionarios',
    name: 'Funcionarios',
    component: Funcionarios
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
