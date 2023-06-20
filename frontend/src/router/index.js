import { createRouter, createWebHistory } from 'vue-router';
import Clientes from '../views/ClientesView.vue';
import Agenda from '../views/AgendaView.vue';
import Pets from '../views/AnimaisView.vue';
import Estoque from '../views/EstoqueView.vue';
import Caixa from '../views/CaixaView.vue';
import Funcionarios from '../views/FuncionariosView.vue';
import Login from '../views/LoginView.vue';
import Swal from "sweetalert2";

function verificarAutenticacao(to, from, next) {
  const token = localStorage.getItem('token');

  if (token) {
    next();
  } else {
      // Se o token não existir, redirecione para a página de login
    Swal.fire({
      icon: 'info',
      title: 'Faça login para acessar esta página',
      showConfirmButton: false,
      timer: 2500,
      timerProgressBar: true
    }).then(() => {
        window.location.href = '/';
    });
  }
}

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
    component: Clientes,
    beforeEnter: verificarAutenticacao
  },
  {
    path: '/agenda',
    name: 'Agenda',
    component: Agenda,
    beforeEnter: verificarAutenticacao,
    
    
  },
  {
    path: '/pets',
    name: 'Pets',
    component: Pets,
   
    beforeEnter: verificarAutenticacao
  },
  {
    path: '/estoque',
    name: 'Estoque',
    component: Estoque,
  
    beforeEnter: verificarAutenticacao
  },
  {
    path: '/caixa',
    name: 'Caixa',
    component: Caixa,

    beforeEnter: verificarAutenticacao
  },
  {
    path: '/funcionarios',
    name: 'Funcionarios',
    component: Funcionarios,
  
    beforeEnter: verificarAutenticacao
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
