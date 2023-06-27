<template>
    <section>
        <div class="custom-container">
            <div class="custom-content">
                <div class="custom-main-content">
                    <div class="super-content">

                        <div class="left-content">
                            <div id="search" class="form-field">
                                <label for="searchTerm">Pesquisar Produto:</label>
                                <input type="text" id="searchTerm" name="searchTerm" v-model="searchTerm"
                                    @keydown.enter="searchProduct" placeholder="Digite o código do produto">
                            </div>
                            <div id="product-list">
                                <ul>
                                    <li v-for="(product, index) in selectedProducts" :key="index" class="product-item">
                                        <div class="product-info">
                                            {{ product.nome }} - Preço: {{ product.valor_venda }}
                                        </div>
                                        <div class="product-actions">
                                            <button @click="decreaseQuantity(product)"
                                                :disabled="product.quantity === 1">-</button>
                                            <input type="text" v-model="product.quantity" min="1" class="quantity-input"
                                                readonly>
                                            <button @click="increaseQuantity(product)">+</button>
                                            <button @click="removeProduct(product)">Remover</button>
                                        </div>
                                    </li>
                                </ul>
                            </div>



                            <div class="total-produto">
                                <div class="total">
                                    <div class="icon-dollar">
                                        <i class="fa-solid fa-basket-shopping"></i>
                                    </div>
                                    <div class="total-valor">
                                        <span class="textTotal">{{ totalQuantity }}</span>
                                        <br>
                                        <span>Quantidade</span>
                                    </div>
                                </div>
                                <div class="total">
                                    <div class="icon-dollar">
                                        <i class="fa-solid fa-dollar-sign"></i>
                                    </div>
                                    <div class="total-valor">
                                        <span class="textTotal">{{ totalValue }}</span>
                                        <br>
                                        <span>Total</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="right-content">
                            asdasdsad
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
  
<script>

import ApiController from '@/ApiController.js';
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            searchTerm: "",
            selectedProduct: null,
            selectedProducts: [],
            loading: true
        };
    },
    methods: {
        async searchProduct() {
            try {
                this.loading = true;
                const produto = await ApiController.buscarProdutosCod(this.searchTerm);
                if (produto) {
                    if (produto.quantidade === 0) {
                        Swal.fire("", "Produto sem estoque.", "warning");
                        this.searchTerm = "";
                    } else {
                        this.selectedProduct = produto;
                        this.addProduct();
                    }
                } else {
                    Swal.fire("", "Código do produto inválido.", "error");
                    this.searchTerm = "";
                }
                this.loading = false;
            } catch (error) {
                console.log("Erro ao listar o produto: ", error);
            }
        },
        addProduct() {
            if (this.selectedProduct) {
                const existingProduct = this.selectedProducts.find(
                    (product) => product.nome === this.selectedProduct.nome
                );

                if (existingProduct) {
                    if (existingProduct.quantity < existingProduct.quantidade) {
                        existingProduct.quantity++;
                    } else {
                        Swal.fire("", "Quantidade máxima atingida.", "warning");
                    }
                } else {
                    this.selectedProduct.quantity = 1;
                    this.selectedProducts.push(this.selectedProduct);
                }

                this.searchTerm = "";
            }
        },

        increaseQuantity(product) {
            if (product.quantity < product.quantidade) {
                product.quantity++;
            } else {
                Swal.fire("", "Quantidade máxima atingida.", "warning");
            }
        },

        decreaseQuantity(product) {
            if (product.quantity > 1) {
                product.quantity--;
            }
        },

        removeProduct(product) {
            const index = this.selectedProducts.indexOf(product);
            if (index !== -1) {
                this.selectedProducts.splice(index, 1);
            }
        },
    },
    computed: {
        totalValue() {
            let total = 0;
            this.selectedProducts.forEach((product) => {
                total += parseFloat(product.valor_venda) * product.quantity
            });
            return total.toFixed(2);
        },
        totalQuantity() {
            let quantity = 0;
            this.selectedProducts.forEach((product) => {
                quantity += parseInt(product.quantity);
            });
            return quantity;
        },
    },
};
</script>

<style>
.quantity-input {
    width: 30px;
    /* Defina o valor desejado para a largura máxima do input */
    text-align: center;
    border-radius: 5px;
    border: none;
}

.product-item {
    display: flex;
    align-items: center;
}

.product-info {
    flex-grow: 1;
}

.product-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.product-actions button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 0.5rem;
    cursor: pointer;
}

.product-actions button:hover {
    background-color: #0056b3;
}

.product-actions button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.total {
    color: white;
    background-color: black;
    border-radius: 5px;
    width: 140px;
    height: 55px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}

.total-valor {
    padding-right: 10px;
    text-align: center;
}

.total-valor>span {
    font-size: 14px;
    color: gray;
}

.total-valor >.textTotal {
    color: white;
    font-size: 16px;
}

.icon-dollar {
    padding-left: 5px;
    font-size: 38px;
    color: gray;
}

.form-field {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 15px;
}

.form-field label {
    font-weight: bold;
}

.form-field input[type="text"],
.form-field input[type="number"],
.form-field select {
    width: 70%;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}


#product-list {
    margin: 15px;
    color: white;
}

#product-list>ul {
    list-style-type: none
}

.total-produto {
    margin-top: auto;
    margin-right: 15px;
    margin-bottom: 20px;
    align-self: flex-end;
    display: flex;
    gap: 15px;
}

.left-content {
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 60%;
    background-color: gray;

    border-radius: 15px;
}

.right-content {
    display: flex;
    height: 80%;
    width: 50%;
    background-color: rgb(129, 127, 127);
    margin: 15px;
}

.super-content {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
}
</style>