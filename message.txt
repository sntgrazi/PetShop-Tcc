<template>
    <!--Nav-->
    <div class="header">
        <nav>
            <img src="../assets/imagem/image_logo.png" alt="logo"> <!--ADICIONAR LOGO-->
            <ul id="navbar">
                <li><a href="#">Home</a></li>
                <li><a href="#">Serviços</a></li>
                <li><a href="#">Galeria</a></li>
            </ul>
            <h1 class="menu">&#9776;</h1>
        </nav>
        <!--Modal-->
        <div class="modal" v-if="showModal">
            <div class="modal-content">
                <span class="close" @click="closeModal">&times;</span>
                <h2>Cadastre-se</h2>
                <p class="modaltext">Experimente uma demonstração grátis!</p>
                <form @submit.prevent="submitForm">
                    <div class="roww">
                        <label for="email" class="label">Email:</label>
                        <input type="email" id="email" name="email" v-model="email" required>
                    </div>
                    <div class="roww">
                        <label for="password" class="label">Senha:</label>
                        <input type="password" id="password" name="password" v-model="password" required>
                    </div>
                    <button type="submit">Cadastrar</button>
                </form>

            </div>
        </div>
        <!--Main-->
        <div class="main">
            <h1>Chegou a hora de levar seu petshop para o próximo nível<br> com nosso sistema de gestão moderno e
                eficiente.<br>
            </h1>
            <a href="#" @click="openModal">Faça um teste</a>
        </div>
        <div class="right-box">
            <img src="../assets/imagem/image-rightbox.png" alt="">
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#04294d" fill-opacity="1"
                d="M0,32L48,53.3C96,75,192,117,288,144C384,171,480,181,576,186.7C672,192,768,192,864,213.3C960,235,1056,277,1152,282.7C1248,288,1344,256,1392,240L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    <!--Serviços-->
    <div class="service">
        <h2 style="margin-bottom: 20px;">Serviços</h2>
        <p>Descubra o poder do nosso sistema, transforme suas operações<br> e impulsione seu sucesso com nossos serviços
            inovadores.</p>
        <div class="row">
            <div class="servicecol">
                <div class="service-offer">
                    <img src="../assets/imagem/img1.png" alt="">
                </div>
                <h4>Agendamento de Pet</h4>
                <h6 class="servicep">Facilitamos o agendamento de serviços e consultas através de uma interface online.</h6>
            </div>
            <div class="servicecol">
                <div class="service-offer">
                    <img src="../assets/imagem/img3.png" alt="">
                </div>
                <h4>Frente de Caixa</h4>
                <h6 class="servicep">Frente de caixa eficiente, que agiliza o processo de vendas e pagamentos.</h6>
            </div>
            <div class="servicecol">
                <div class="service-offer">
                    <img src="../assets/imagem/img2.png" alt="">
                </div>
                <h4>Gestão Integrada</h4>
                <h6 class="servicep">Nosso sistema permite a gestão eficiente de clientes, pets, funcionários, produtos e fornecedores.</h6>
            </div>
        </div>
        <!--Carousel-->
        <div class="carouselContainer">
            <div class="carousel">
                <h2 style="margin-bottom: 50px;">Galeria de Imagens</h2>
                <div class="carousel-inner">
                    <div v-for="(item, index) in carouselItems" :key="index"
                        :class="['carousel-item', { 'active': index === activeIndex }]">
                        <img :src="item.image" :alt="item.caption" class="carousel-image">
                    </div>
                </div>
                <a class="carousel-control-prev" @click="prevSlide">&#10094;</a>
                <a class="carousel-control-next" @click="nextSlide">&#10095;</a>
            </div>
        </div>
    </div>
    <!--Botão back to top-->
    <div class="back-to-top" v-if="showBackToTop" @click="scrollToTop">
        <i class="fa fa-arrow-up"></i>
    </div>
    <!--Footer-->
    <footer>
        <div class="bottom-details">
            <div class="bottom_text">
                <span class="copyright_text">Copyright © 2023 All rights reserved</span>
            </div>
        </div>
    </footer>
</template>

<script>

import '../css/style.css';

export default {
    
    data() {
        return {
            showModal: false,
            email: '',
            password: '',
            showBackToTop: false,
            activeIndex: 0,
            carouselTimer: null,
            carouselItems: [
                {
                    image: "../src/assets/imagem/care1.png",
                },
                {
                    image: "../src/assets/imagem/care2.png",
                },
                {
                    image: "../src/assets/imagem/care3.png",
                }
            ]
        }
    },

    mounted() {
        window.addEventListener('scroll', this.handleScroll);
    },

    created() {
        this.startCarouselTimer();
    },

    destroyed() {
        this.stopCarouselTimer();
        window.removeEventListener('scroll', this.handleScroll);
    },

    methods: {
        openModal() {
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
        },

        submitForm() {
            const payload = {
                email: this.email,
                password: this.password,
            };

            fetch('https://petshoptcc.ew.r.appspot.com/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            })
                .then((response) => {
                    if (response.ok) {
                        swal({
                            title: 'Está tudo ok ?',
                            text: 'Tenha em mente que este email e senha serão usados para fazer login no sistema',
                            icon: 'info',
                            button: 'OK'
                        }).then(() => {
                            window.location.href = 'https://tccpetshop.vercel.app/'; 
                        });

                    }
                    else {
                        swal({
                            title: 'Erro!',
                            text: 'Erro ao registrar usuário',
                            icon: 'error',
                            button: 'OK'
                        });
                    }
                })
                .catch((error) => {
                    console.error('Erro ao realizar cadastro:', error);
                    this.message = 'Erro ao realizar cadastro.';
                });
            this.email = ''
            this.password = ''
            this.closeModal();
        },

        prevSlide() {
            this.activeIndex = (this.activeIndex - 1 + this.carouselItems.length) % this.carouselItems.length;
        },

        nextSlide() {
            this.activeIndex = (this.activeIndex + 1) % this.carouselItems.length;
        },

        startCarouselTimer() {
            this.carouselTimer = setInterval(this.nextSlide, 8000);
        },

        stopCarouselTimer() {
            clearInterval(this.carouselTimer);
            this.carouselTimer = null;
        },

        handleScroll() {
            this.showBackToTop = window.scrollY > 500;
        },

        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    },
}
</script>