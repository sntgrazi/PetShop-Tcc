<template>
    <main>
        <div class="box">
            <div class="inner-box">
                <!--Login-->
                <div class="forms-wrap">
                    <form @submit.prevent="login()" autocomplete="off" class="sign-in-form">
                        <div class="logo">
                            <img src="../assets/img/image.png" alt="easyclass">
                            <h4>Doo pet's</h4>
                        </div>

                        <div class="heading">
                            <h2>Bem vindo ao Doo Pet's</h2>

                        </div>

                        <div class="actual-form">
                            <div class="input-wrap"> <!--Login-->
                                <input v-model="email" type="email" minlength="4" class="input-field" autocomplete="off"
                                    required />
                                <label>Email</label>
                            </div>

                            <div class="input-wrap">
                                <input v-model="senha" type="password" minlength="6" class="input-field" autocomplete="off"
                                    required />
                                <label>Senha</label>
                            </div>

                            <button type="submit" class="sign-btn"> Entrar</button>

                            <p class="text">
                                Esqueceu a
                                <a class="textpass" href="#">senha?</a>
                            </p>
                        </div>
                    </form>
                    <!--Fim de Login-->

                    <!--  <form action="index.html" autocomplete="off" class="sign-up-form">
                        <div class="logo">
                            <img src="../assets/img/image.png" alt="easyclass" />
                            <h3>Doo pet's</h3>
                        </div>

                        <div class="heading">
                            <h2>Bem vindo ao Doo pet's</h2>
                            <h6>Já tem</h6>
                            <a href="#" class="toggle">login?</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Nome</label>
                            </div>

                            <div class="input-wrap">
                                <input type="email" class="input-field" autocomplete="off" required />
                                <label>Email</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Senha</label>
                            </div>
                            <input type="submit" value="Cadastrar" class="sign-btn" />

                        </div>
                    </form> -->


                </div>
                <!-- Carousel -->
                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="../assets/img/carousel_1.png" class="image img-1 show" id="img1" alt="" />
                        <img src="../assets/img/carousel_2.png" class="image img-2" id="img2" alt="" />
                        <img src="../assets/img/carousel_3.png" class="image img-3" id="img3" alt="" />
                    </div>
                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h3>Deixe o seu bichinho glamuroso!</h3>
                                <h3>Felicidade é comer ração de qualidade!</h3>
                                <h3>Banho e tosa para o seu bichinho!</h3>
                            </div>
                        </div>
                        <div class="bullets">
                            <span class="active" data-value="1"></span>
                            <span data-value="2"></span>
                            <span data-value="3"></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</template>

<script>
import { onBeforeUnmount } from 'vue';
import ApiController from "@/ApiController";
import Swal from "sweetalert2";

export default {
    name: 'LoginView',
    data() {
        return {
            email: '',
            senha: ''
        }
    },
    methods: {
        async login() {
            try {
                await ApiController.login(this.email, this.senha);

            } catch (error) {
                console.log("Erro ao tentar fazer login: ", error);

                Swal.fire({
                    icon: 'error',
                    title: 'Senha incorreta',
                    text: 'A senha informada está incorreta. Por favor, tente novamente.',
                });
            }
        }
    },
    mounted() {

        const inputs = document.querySelectorAll(".input-field");
        const bullets = document.querySelectorAll(".bullets span");
        const images = document.querySelectorAll(".image");

        inputs.forEach((inp) => {
            inp.addEventListener("focus", () => {
                inp.classList.add("active");
            });
            inp.addEventListener("blur", () => {
                if (inp.value != "") return;
                inp.classList.remove("active");
            });
        });

        let count = 1;
        document.getElementById("img1").checked = true;

        const totalImages = 3; // Total de imagens disponíveis
        const interval = 2200; // Intervalo de tempo em milissegundos

        function moveSlider(index) {
            let currentImage = document.querySelector(`.img-${index}`);
            images.forEach((img) => img.classList.remove("show"));
            currentImage.classList.add("show");

            const textSlider = document.querySelector(".text-group");
            textSlider.style.transform = `translateY(${-(index - 1) * 2.4}rem)`;

            bullets.forEach((bull) => bull.classList.remove("active"));
            bullets[index - 1].classList.add("active");
        }

        function nextImage() {
            count++;
            if (count > totalImages) {
                count = 1;
            }
            const imageInput = document.getElementById(`img${count}`);
            if (imageInput) {
                imageInput.checked = true;
                moveSlider(count);
            }
        }

        let intervalId = setInterval(nextImage, interval);

        // Limpar o intervalo quando o componente for destruído

        onBeforeUnmount(() => {
            clearInterval(intervalId);
        });


    }
}
</script>

<style scoped>
main {
    width: 100%;
    min-height: 100vh;
    overflow: hidden;
    background-color: #e2ebf4;
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.box {
    position: relative;
    width: 100%;
    max-width: 1020px;
    height: 595px;
    background-color: #1E90FF;
    border-radius: 3.3rem;
    box-shadow: 0 60px 40px -30px rgba(0, 0, 0, 0.27);
}

.inner-box {
    position: absolute;
    width: calc(100% - 4.1rem);
    height: calc(100% - 4.1rem);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.forms-wrap {
    /*Caixa direita*/
    position: absolute;
    height: 100%;
    width: 45%;
    top: 0;
    left: 0;
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: 1fr;
    transition: 0.8s ease-in-out;
}


form {
    /*Formato esquerdo*/
    max-width: 260px;
    width: 100%;
    margin: 0 auto;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    grid-column: 1 / 2;
    grid-row: 1 / 2;
    transition: opacity 0.02s 0.4s;
}

form.sing-in-form {
    display: none;
}

form.sign-up-form {
    opacity: 0;
    pointer-events: none;
}


.logo {
    display: flex;
    align-items: center;
}

.logo img {
    width: 27%;
    margin-right: 0.3rem;
}

.logo h4 {
    font-size: 1.8rem;
    margin-top: 1 px;
    letter-spacing: -0.5px;
    color: #e2ebf4;
    font-weight: bold;
}

.heading h2 {
    font-size: 2.1rem;
    font-weight: 600;
    color: #04294d;
}

.heading h6 {
    color: #04294d;
    font-weight: bold;
    font-size: 0.9rem;
    display: inline;
}

.toggle {
    color: white;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: bold;
    transition: 0.3s;
}

.toggle:hover {
    color: #04294d;
    transition: 1s;
}

.input-wrap {
    position: relative;
    height: 37px;
    margin-bottom: 2rem;
}

.input-field {
    position: absolute;
    width: 100%;
    height: 100%;
    background: none;
    border: none;
    outline: none;
    border-bottom: 1px solid #fdfafa;
    padding: 0;
    font-size: 0.95rem;
    color: #151111;
    transition: 0.4s;
}

label {
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.95rem;
    color: #ffffff;
    pointer-events: none;
    transition: 0.4s;
}

.active {
    border-bottom-color: #151111;
}

.active+label {
    font-size: 0.75rem;
    top: -2px;
}

.sign-btn {
    display: inline-block;
    width: 100%;
    height: 43px;
    background-color: #0a5096;
    color: #ffffff;
    border: none;
    cursor: pointer;
    border-radius: 0.2rem;
    font-size: 0.8rem;
    margin-bottom: 2rem;
}

.sign-btn:hover {
    background-color: #ffffff;
    color: #151111;
    transition: 1s;
}

.text {
    color: #04294d;
    font-weight: bold;
}

.textpass {
    color: white;
    text-decoration: none;
}

.textpass:hover {
    color: #04294d;
    transition: 1s;
}

main.sign-up-mode form.sign-in-form {
    opacity: 0;
    pointer-events: none;
}

main.sign-up-mode form.sign-up-form {
    opacity: 1;
    pointer-events: all;
}

main.sign-up-mode .forms-wrap {
    left: 55%;
}

main.sign-up-mode .carousel {
    left: 0%;
}

/*CAROUSEL*/

.carousel {
    position: absolute;
    height: 100%;
    width: 55%;
    left: 45%;
    top: 0;
    background-color: #1477d9;
    border-radius: 2rem;
    display: grid;
    flex-direction: column;
    grid-template-rows: auto 1fr;
    padding-bottom: 2rem;
    overflow: hidden;
    transition: 0.8s ease-in-out;
}

.images-wrapper {
    /*imagem do carousel*/
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: 1fr;
}

.image {
    width: 90%;
    grid-column: 1/2;
    grid-row: 1/2;
    opacity: 0;
    transition: opacity 0.3s, transform 0.5s;
}

.img-1 {
    transform: translate(0, -50px, );
    margin-left: 25px
}

.img-2 {
    transform: scale(0.4, 0.5);
    margin-left: 24px;
}

.img-3 {
    transform: scale(0, 3) rotate(-20deg);
}

.image.show {
    opacity: 1;
    transform: none;
}

.text-slider {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.text-wrap {
    max-height: 2.2rem;
    overflow: hidden;
    margin-bottom: 2.5rem;
}

.text-group {
    display: flex;
    flex-direction: column;
    text-align: center;
    transform: translateY(0);
    transition: 0.5s;
}

.text-group h3 {
    line-height: 2.2rem;
    font-weight: 600;
    font-size: 1.5rem;
    color: #e2ebf4;
}

.bullets {
    display: flex;
    align-items: center;
    justify-content: center;
}

.bullets span {
    display: block;
    width: 0.5rem;
    height: 0.5rem;
    background-color: #ffffff;
    margin: 0 0.25rem;
    border-radius: 50%;
    cursor: pointer;
    transition: 0.3s;
}

.bullets span.active {
    width: 1.1rem;
    background-color: #04294d;
    border-radius: 1rem;
}

/*Responsividade*/

@media (max-width: 850px) {
    .box {
        height: auto;
        max-width: 550px;
        overflow: hidden;
    }

    .inner-box {
        position: static;
        transform: none;
        width: revert;
        height: revert;
    }

    .forms-wrap {
        position: revert;
        width: 100%;
        height: auto;
    }

    form {
        max-width: revert;
        padding: 1.5rem 2.5rem 2rem;
    }

    .heading {
        margin: 2rem 0;
    }

    form.sing-up-form {
        transform: translateX(-100%);
    }

    main.sign-up-mode form.sing-in-form {
        transform: translateX(-100%);
    }

    main.sign-up-mode form.sign-up-form {
        transform: translateX(0%);
    }

    .carousel {
        position: revert;
        height: auto;
        width: 100%;
        padding: 3rem 2rem;
        display: flex;
    }

    .images-wrapper {
        display: none;
    }

    .text-slider {
        width: 100%;
    }
}

@media (max-width: 580px) {
    main {
        padding: 1rem;
    }

    .box {
        border-radius: 2rem;
    }

    .inner-box {
        padding: 1rem;
    }

    .carousel {
        padding: 1.5rem 1rem;
        border-radius: 1.6rem;
    }

    .text-wrap {
        margin-bottom: 1rem;
    }

    .text-group h3 {
        font-size: 0.8rem;
    }

    form {
        padding: 1rem 2rem 1.5rem;
    }
}
</style>