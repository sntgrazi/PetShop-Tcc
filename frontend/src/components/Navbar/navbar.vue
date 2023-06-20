<template>
  <header class="custom-header" id="header">
    <div class="custom-header__toggle">
      <i class="bx bx-menu" id="header-toggle"></i>
    </div>
    <div class="custom-header__img">
      <img src="" alt="" />
    </div>
  </header>

  <div class="custom-sidebar" id="nav-bar">
    <div class="custom-logo-details">
      <i class="fa-solid fa-shield-dog custom-icon"></i>
      <div class="custom-logo_name">PETSHOP</div>
    </div>
    <ul class="custom-nav-list">
      <hr />
      <li>
        <router-link to="/agenda">
          <a href="#">
            <i class="fa-solid fa-calendar-days"></i>
            <span class="custom-links_name">Agenda</span>
          </a>
        </router-link>
        <span class="custom-tooltip">Agenda</span>
      </li>
      <li>
        <router-link to="/caixa">
          <a href="#">
            <i class="fa-solid fa-basket-shopping"></i>
            <span class="custom-links_name">Caixa</span>
          </a>
        </router-link>
        <span class="custom-tooltip">Caixa</span>
      </li>
      <li>
        <a href="#">
          <router-link to="/clientes">
            <i class="fa-solid fa-users"></i>
            <span class="custom-links_name">Clientes</span>
          </router-link>
        </a>
        <span class="custom-tooltip">Clientes</span>
      </li>
      <li>
        <router-link to="/pets">
          <a href="#">
            <i class="fa-solid fa-dog"></i>
            <span class="custom-links_name">Pets</span>
          </a>
        </router-link>
        <span class="custom-tooltip">Pets</span>
      </li>
      <li>
        <router-link to="/estoque">
          <a href="#">
            <i class="fa-solid fa-box"></i>
            <span class="custom-links_name">Estoque</span>
          </a>
        </router-link>
        <span class="custom-tooltip">Estoque</span>
      </li>
      <hr />
      <li>
        <a href="#">
          <i class="fa-solid fa-gear"></i>
          <span class="custom-links_name">Configurações</span>
        </a>
        <span class="custom-tooltip">Configurações</span>
      </li>
      <li>
        <router-link to="/funcionarios">
          <a href="#">
            <i class="fa-solid fa-user"></i>
            <span class="custom-links_name">Funcionários</span>
          </a>
        </router-link>
        <span class="custom-tooltip">Funcionários</span>
      </li>
      <li class="custom-profile">
        <a href="#" @click="logout()">
          <i class="bx bx-log-out" id="log_out"></i>
          <span class="custom-links_name">Sair</span>
        </a>
        <span class="custom-tooltip">Sair</span>
      </li>

    </ul>
  </div>
</template>

<script>
import "@/assets/css/style.css";
import { showNavbar } from "@/assets/js/funcoes";
import Swal from 'sweetalert2';

export default {
  name: "Navbar",
  methods: {
    showNavbar: showNavbar,
    logout() {
      Swal.fire({
        title: 'Deseja sair?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          localStorage.removeItem('token');
      
      // Redirecione para a página de login
           window.location.href = '/';
        }
      });
    }
  },
  mounted() {
    const toggle = document.getElementById("header-toggle");
    toggle.addEventListener("click", event => {
      event.stopPropagation();
      showNavbar("header-toggle", "nav-bar", "header", "body-pd");
    });

    var isLoginPage = window.location.pathname === '/';

    if (!isLoginPage) {
      window.addEventListener("click", event => {
        const nav = document.getElementById("nav-bar");
        if (nav.classList.contains("open") && !event.target.closest("#nav-bar")) {
          showNavbar("header-toggle", "nav-bar", "header", "body-pd");
        }
      });
    }
  }
};
</script>

<style></style>