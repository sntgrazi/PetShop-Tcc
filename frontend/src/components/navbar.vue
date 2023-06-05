<template>
    <header class="header" id="header">
        <div class="header__toggle">
            <i class="bx bx-menu" id="header-toggle"></i>
        </div>
    </header>

    <div class="sidebar" id="nav-bar">
        <div class="logo-details">
            <i class="fa-solid fa-shield-dog icon"></i>
            <div class="logo_name">DooPet's</div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav-list">
            <hr />
            <li>
                <router-link to="/">
                    <a href="#">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span class="links_name">Agenda</span>
                    </a>
                </router-link>

                <span class="tooltip">Agenda</span>
            </li>
            <li>
                <a href="#">
                    <i class="fa-solid fa-basket-shopping"></i>
                    <span class="links_name">Caixa</span>
                </a>
                <span class="tooltip">Caixa</span>
            </li>
            <li>
                <router-link to="/clientes">
                    <a href="#">
                        <i class="fa-solid fa-users"></i>
                        <span class="links_name">Clientes</span>
                    </a>
                </router-link>
                <span class="tooltip">Clientes</span>
            </li>
            <li>
                <router-link to="/pets">
                    <a href="#">
                        <i class="fa-solid fa-dog"></i>
                        <span class="links_name">Pets</span>
                    </a>
                </router-link>
                <span class="tooltip">Pets</span>
            </li>
            <li>
                <a href="#">
                    <i class="fa-solid fa-box"></i>
                    <span class="links_name">Estoque</span>
                </a>
                <span class="tooltip">Estoque</span>
            </li>
            <hr />
            <li>
                <a href="#">
                    <i class="fa-solid fa-gear"></i>
                    <span class="links_name">Configurações</span>
                </a>
                <span class="tooltip">Configurações</span>
            </li>
            <li class="profile">
                <a href="#">
                    <i class="bx bx-log-out"></i>
                    <span class="links_name">Sair</span>
                </a>
                <span class="tooltip">Sair</span>
            </li>
        </ul>
    </div>
</template>

<script>
import { showNavbar } from "@/assets/js/funcoes";
export default {
    methods:{
        showNavbar: showNavbar
    },  
    mounted() {
        let sidebar = document.querySelector(".sidebar");
        let closeBtn = document.querySelector("#btn");

        closeBtn.addEventListener("click", () => {
            sidebar.classList.toggle("open");
            menuBtnChange();//calling the function(optional)
        });
        // following are the code to change sidebar button(optional)
        function menuBtnChange() {
            if (sidebar.classList.contains("open")) {
                closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
            } else {
                closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");//replacing the iocns class
            }
        }

        const toggle = document.getElementById("header-toggle");
        toggle.addEventListener("click", event => {
            event.stopPropagation();
            showNavbar("header-toggle", "nav-bar", "header", "body-pd");
        });
    }
}
</script>

<style>
@media (max-width: 420px) {
    .sidebar li .tooltip {
        display: none;
    }
}
</style>