<template>
    <section>
        <div class="custom-container">
            <topo :type="'Funcionario'" :icon="'fa-plus'" />
            <div class="custom-content">
                <div class="custom-main-content">
                    <div class="super-content">
                        <div class="left-content">
                            <div id="search" class="form-field">
                                <label for="searchTerm">Pesquisar Produto:</label>
                                <input type="text" id="searchTerm" name="searchTerm" v-model="searchTerm"
                                    @keydown.enter="searchProduct" placeholder="Digite o código do produto" />
                            </div>
                            <div id="product-list">
                                <div v-if="selectedProducts.length === 0" class="no-products-message">
                                    Selecione produtos e/ou serviços acima.
                                </div>
                                <ul>
                                    <li v-for="(product, index) in selectedProducts" :key="index" class="product-item">
                                        <div class="product-info">
                                            {{ product.nome }} - Preço: {{ product.valor_venda }}
                                        </div>
                                        <div class="product-actions">
                                            <button @click="decreaseQuantity(product)" :disabled="product.quantity === 1">
                                                -
                                            </button>
                                            <input type="text" v-model="product.quantity" min="1" class="quantity-input"
                                                readonly />
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
                                        <br />
                                        <span>Quantidade</span>
                                    </div>
                                </div>
                                <div class="total">
                                    <div class="icon-dollar">
                                        <i class="fa-solid fa-dollar-sign"></i>
                                    </div>
                                    <div class="total-valor">
                                        <span class="textTotal">{{ totalValue }}</span>
                                        <br />
                                        <span>Total</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="right-content">
                            <div class="tituloRight">
                                <span>Pagamento</span>
                            </div>
                            <div v-for="(paymentForm, index) in paymentForms" :key="index" class="payment-form">
                                <div class="form-field-pay">
                                    <label>Forma de Pagamento</label>
                                    <select v-model="paymentForm.paymentMethod" id="select-payMethod"
                                        class="select-payMethod">
                                        <option v-for="method in paymentMethods" :value="method">{{ method }}</option>
                                    </select>
                                </div>

                                <div class="form-field-pay">
                                    <label>Valor</label>
                                    <input type="text" v-model="paymentForm.paymentAmount" />
                                </div>
                                <div class="form-field-pay">
                                    <label>Parcelas</label>
                                    <div class="input-group-p">
                                        <select v-model="paymentForm.installments" id="select-payParc"
                                            class="select-payParc">
                                            <option v-for="installment in installments" :value="installment">{{ installment
                                            }}</option>
                                        </select>
                                        <button v-if="index > 0" class="btn-removerForma"
                                            @click="removerFormaPagamento(index)"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            <button class="my-button" v-if="!formAdicionado" @click="adicionarFormaPagamento">Adicionar
                                Forma de
                                Pagamento
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
  
<script>
import topo from "@/components/Outros/topo.vue";
import ApiController from "@/ApiController.js";
import Swal from "sweetalert2";
import $ from "jquery";
import "select2/dist/css/select2.css";
import "select2";

export default {
    data() {
        return {
            searchTerm: "",
            selectedProduct: null,
            selectedProducts: [],
            loading: true,
            paymentForms: [
                {
                    paymentMethod: "",
                    paymentAmount: "",
                    installments: "",
                },
            ],
            formAdicionado: false,
            installments: Array.from({ length: 12 }, (_, index) => `${index + 1}x`), // Array de parcelas no formato "1x" a "12x"
            paymentMethods: ['Crédito', 'Débito', 'Boleto', 'Pix'], // Array com os métodos de pagamento
        };
    },
    components: {
        topo,
    },
    methods: {
        adicionarFormaPagamento() {
            this.paymentForms.push({
                paymentMethod: "",
                paymentAmount: "",
                installments: "",
            });
            this.formAdicionado = true;
        },
        removerFormaPagamento(index) {
            this.paymentForms.splice(index, 1); // Remove a forma de pagamento da lista pelo índice
            this.formAdicionado = false;
        },
        async searchProduct() {
            try {
                this.loading = true;
                const produto = await ApiController.buscarProdutosCod(this.searchTerm);
                if (produto) {
                    if (produto.tabela === "produtos" && produto.quantidade === 0) {
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
                    if (
                        existingProduct.tabela === "servicos" ||
                        existingProduct.quantity < existingProduct.quantidade
                    ) {
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
            if (product.tabela === "servicos") {
                // Para serviços, não há limite de quantidade
                product.quantity++;
            } else {
                if (product.quantity < product.quantidade) {
                    product.quantity++;
                } else {
                    Swal.fire("", "Quantidade máxima atingida.", "warning");
                }
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
                total += parseFloat(product.valor_venda) * product.quantity;
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
.my-button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    margin: 0 auto;
}

.my-button:hover {
    background-color: #0056b3;
}

.btn-removerForma {
    border: none;
    margin-left: 25px;
    cursor: pointer;
    background: transparent;
}

.btn-removerForma>i {
    font-size: 18px;
    color: red;
}

.select-payMethod {
    width: 220px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.select-payParc {
    width: 80px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.tituloRight {
    background-color: rgb(197, 195, 195);
    width: 100%;
    text-align: center;
    border-radius: 15px 15px 0 0;
    font-size: 18px;
}

.payment-form {
    display: flex;
    flex-direction: row;
}

.form-field-pay {
    width: 100%;
    margin: 15px;
}

.form-field-pay label {
    font-weight: bold;
    white-space: nowrap;
}

.form-field-pay input[type="text"] {
    width: 100%;
    padding: 9px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 10px;
}

.outroForm {
    display: flex;
}

.no-products-message {
    text-align: center;
    margin-top: 20px;
    font-size: 18px;
    color: #999;
}

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
    margin-bottom: 10px;
}

.product-info {
    flex-grow: 1;
    color: black;
}

.product-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.product-actions button {
    background-color: #1e90ff;
    color: #fff;
    border: none;
    padding: 0.5rem;
    cursor: pointer;
    border-radius: 5px;
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
    background-color: #1e90ff;
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

.icon-dollar .fa-solid {
    color: rgb(255, 255, 255);
}

.total-valor>span {
    font-size: 14px;
    color: rgb(255, 255, 255);
}

.total-valor>.textTotal {
    color: rgb(255, 255, 255);
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

.form-field input[type="text"] {
    width: 70%;
    padding: 8px;
    border: 1px solid black;
    border-radius: 4px;
}

#product-list {
    margin: 15px;
    color: white;
}

#product-list>ul {
    list-style-type: none;
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
    height: 90%;
    width: 50%;
    margin: 15px;
    background-color: white;
    border-radius: 15px;
}

.right-content {
    display: flex;
    height: 90%;
    width: 50%;
    background-color: white;
    border: 1px solid rgb(134, 134, 134);
    margin: 15px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    border-radius: 15px;
}

.super-content {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    background-color: white;
    border-radius: 20px;
}

@media screen and (max-width: 600px) {
    .super-content {
        flex-direction: column;
    }

    .left-content,
    .right-content {
        width: 100%;
        overflow: scroll;
    }
}
</style>