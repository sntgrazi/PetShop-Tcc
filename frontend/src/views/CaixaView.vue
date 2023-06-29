<template>
    <section>
        <div class="custom-container">
            <topo :type="'Caixa'" :icon="'fa-clock-rotate-left'" :buscarHistorico="buscarHistorico" />
            <div class="custom-content">
                <div class="custom-main-content">
                    <loading :loading="loading" />
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
                                    <select v-model="paymentForm.metodos_pagamento" id="select-payMethod"
                                        class="select-payMethod">
                                        <option v-for="method in paymentMethods" :value="method">{{ method }}</option>
                                    </select>
                                </div>

                                <div class="form-field-pay">
                                    <label>Valor (R$)</label>
                                    <input type="text" v-model="paymentForm.valor_total" />
                                </div>
                                <div class="form-field-pay">
                                    <label>Parcelas</label>
                                    <div class="input-group-p">
                                        <select v-model="paymentForm.parcelas" id="select-payParc" class="select-payParc">
                                            <option v-for="installment in installments" :value="installment">{{ installment
                                            }}</option>
                                        </select>
                                        <button v-if="index > 0" class="btn-removerForma"
                                            @click="removerFormaPagamento(index)"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            <button id="btn-adicionar" v-if="!formAdicionado" @click="adicionarFormaPagamento">Adicionar
                                Forma de Pagamento</button>
                            <div class="my-button-venda">
                                <button class="my-button" id="cancelar-btn" @click="cancelarVenda">Cancelar Venda</button>
                                <button class="my-button" @click="fecharVenda">Fechar Venda</button>
                            </div>
                        </div>
                    </div>
                    <div id="historicoCanvas" class="offcanvas offcanvas-end">
                        <div class="offcanvas-header">
                            <h5 style="color: #1e90ff;" class="offcanvas-title">Histórico de Vendas</h5>
                            <button id="historicoCloseBtn" class="btn-close text-reset"
                                data-bs-dismiss="offcanvas"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul id="historicoList">
                                <li v-for="(venda, index) in historico" :key="index">
                                    <p>ID da venda: {{ venda.id }}</p>
                                    <p>Data da venda: {{ venda.data_venda }}</p>
                                    <p>Valor total: R$ {{ venda.valor_total }}</p>
                                    <p v-if="venda.quantidade_produtos !== null">Quantidade: {{ venda.quantidade_produtos }}
                                    </p>
                                    <p v-if="venda.metodos_pagamento !== null">Métodos de pagamento: {{
                                        venda.metodos_pagamento }}</p>
                                    <p>==================================</p>
                                    <p v-if="venda.produto_id !== null">ID do produto: {{ venda.produto_id }}</p>
                                    <p v-if="venda.nome_produto !== null">Nome do produto: {{ venda.nome_produto }}</p>
                                    <p v-if="venda.quantidade_produto !== null">Quantidade do produto: {{
                                        venda.quantidade_produto }}</p>
                                    <p>==================================</p>
                                    <p v-if="venda.servico_id !== null">ID do serviço: {{ venda.servico_id }}</p>
                                    <p v-if="venda.nome_servico !== null">Nome do serviço: {{ venda.nome_servico }}</p>
                                    <p v-if="venda.quantidade_servico !== null">Quantidade do serviço: {{
                                        venda.quantidade_servico }}</p>
                                </li>
                                <li v-if="historico.length === 0">Não há vendas.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
  
<script>
import moment from 'moment';
import topo from "@/components/Outros/topo.vue";
import ApiController from "@/ApiController.js";
import Swal from "sweetalert2";
import "select2/dist/css/select2.css";
import "select2";
import loading from '../components/Outros/loading.vue';

export default {
    data() {
        return {
            searchTerm: "",
            selectedProduct: null,
            selectedProducts: [],
            loading: true,
            paymentForms: [
                {
                    metodos_pagamento: "",
                    valor_total: "",
                    parcelas: "",
                },
            ],
            formAdicionado: false,
            installments: Array.from({ length: 12 }, (_, index) => `${index + 1}x`), // Array de parcelas no formato "1x" a "12x"
            paymentMethods: ['Crédito', 'Débito', 'Boleto', 'Pix'],
            historico: {} // Array com os métodos de pagamento
        };
    },
    components: {
        topo,
        loading
    },
    methods: {
        async buscarHistorico() {
            try {
                this.loading = true;
                const historico = await ApiController.historico();

                // Ajustar a diferença de fuso horário (3 horas) no horário do servidor
                historico.forEach((venda) => {
                    const dataVenda = new Date(venda.data_venda);
                    dataVenda.setHours(dataVenda.getHours() - 3); // Subtrai 3 horas
                    venda.data_venda = dataVenda.toLocaleString();
                });

                this.historico = historico;
                this.loading = false;
                $("#historicoCanvas").offcanvas("show");
            } catch (error) {
                console.log("Erro ao buscar o histórico: ", error);
            }
        },

        cancelarVenda() {
            Swal.fire({
                title: 'Cancelar Venda',
                text: 'Deseja realmente cancelar a venda?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.limparCampos();

                    localStorage.removeItem("selectedProducts");
                    Swal.fire('', 'Venda cancelada com sucesso', 'success');
                }
            });
        },
        async fecharVenda() {
            let metodosPagamento = [];
            let valorTotal = 0;
            let parcelasTotal = 0;
            let allInputsFilled = true; // Variável para verificar se todos os inputs estão preenchidos
            let hasSelectedProducts = this.selectedProducts.length > 0; // Verificar se há pelo menos um produto selecionado

            this.paymentForms.forEach((form) => {
                if (!form.metodos_pagamento || !form.valor_total || !form.parcelas) {
                    allInputsFilled = false;
                } else {
                    let valor = parseFloat(form.valor_total);
                    valorTotal += valor;

                    metodosPagamento.push(form.metodos_pagamento);
                    parcelasTotal += parseInt(form.parcelas);
                }
            });

            if (!hasSelectedProducts) {
                Swal.fire("", "Selecione pelo menos um produto antes de fechar a venda.", "warning");
                return;
            }

            if (!allInputsFilled) {
                Swal.fire("", "Preencha todos os campos antes de fechar a venda.", "warning");
                return;
            }

            if (valorTotal > parseFloat(this.totalValue)) {
                Swal.fire("", "O valor a ser pago não pode ser maior que o total ao lado.", "warning");
                return;
            } else if (valorTotal < parseFloat(this.totalValue)) {
                Swal.fire("", "O valor a ser pago não pode ser menor que o total ao lado.", "warning");
                return;
            }

            const resultado = {
                metodos_pagamento: metodosPagamento,
                valor_total: valorTotal,
                parcelas: parcelasTotal + "x",
                produtos: this.selectedProducts
            };

            await ApiController.cadastrarVenda(resultado).catch(error => {
                console.log("Erro ao tentar realizar a venda: ", error)
            });

            Swal.fire({
                title: "Resumo",
                html: `
            <p><strong>Métodos de Pagamento:</strong> ${metodosPagamento.join(', ')}</p>
            <p><strong>Valor Total:</strong> R$ ${valorTotal.toFixed(2)}</p>
            <p><strong>Parcelas:</strong> ${parcelasTotal}x</p>
            <p><strong>Produtos:</strong></p>
            <ul>
                ${this.selectedProducts.map(product => `<li>${product.nome} - R$ ${product.valor_venda} (${product.quantity})</li>`).join('')}
            </ul>
        `,
                confirmButtonText: "OK",
                confirmButtonColor: "#3085d6",
                icon: "info"
            }).then(() => {
                // Limpar o localStorage ao fechar a venda ou cancelar
                localStorage.removeItem("selectedProducts");
                Swal.fire("", "Venda realizada com sucesso", "success");

                // Limpar os campos de inputs após realizar a venda
                this.limparCampos()
            });
        },
        limparCampos() {
            this.paymentForms.forEach((form) => {
                form.metodos_pagamento = '';
                form.valor_total = '';
                form.parcelas = '';
            });
            this.selectedProducts = [];
        },
        adicionarFormaPagamento() {
            this.paymentForms.push({
                metodos_pagamento: "",
                valor_total: "",
                parcelas: "",
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

                // Armazenar no localStorage
                localStorage.setItem("selectedProducts", JSON.stringify(this.selectedProducts));
            }
        },
        beforeDestroy() {

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
                localStorage.setItem("selectedProducts", JSON.stringify(this.selectedProducts));
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
    mounted() {
        this.loading = false
        const storedProducts = localStorage.getItem("selectedProducts");
        if (storedProducts) {
            this.selectedProducts = JSON.parse(storedProducts);
        }
    }
};
</script>

<style>
#historicoList {
    list-style-type: none;
    padding: 0;
}

#historicoList li {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
}

#historicoList li p {
    margin: 5px 0;
}

#btn-adicionar {
    background-color: #1E90FF;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    margin: 0 auto;
}

#cancelar-btn {
    background-color: red;
}

#cancelar-btn:hover {
    background-color: rgb(185, 5, 5);
}

.my-button-venda {
    width: 100%;
    height: 90%;
    display: flex;
    align-items: flex-end;
    justify-content: center;

    margin-bottom: 15px;
}

.my-button {
    width: 40%;
    height: 55px;
    background-color: #0e8f2a;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    margin: 0 auto;
}

.my-button:hover {
    background-color: #157a08;
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
    background-color: #1e90ff;
    width: 100%;
    padding: 10px;
    text-align: center;
    border-radius: 15px 15px 0 0;
    font-size: 18px;
    color: white;
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
    box-shadow: 0 0rem 0.2rem rgba(131, 129, 129, 0.658);
}

.right-content {
    display: flex;
    height: 90%;
    width: 50%;
    background-color: white;
    margin: 15px;
    display: flex;
    margin-left: 20px;
    flex-direction: column;
    align-items: flex-start;
    border-radius: 15px;
    box-shadow: 0 0rem 0.2rem rgba(131, 129, 129, 0.658);
}

.super-content {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    background-color: #e2ebf4;
    border-radius: 20px;

}

@media screen and (max-width: 1020px) {
    .super-content {
        flex-direction: column;
    }

    .left-content {
        overflow: scroll;
    }

    .right-content {
        margin-top: 20px;
        overflow-x: scroll;
    }

    .left-content,
    .right-content {
        width: 100%;
    }

    .payment-form {
        flex-direction: column;
        width: 100%;
    }

    .form-field-pay {
        width: 90%;
    }

    .select-payMethod {
        width: 100%;
    }

    .select-payParc {
        width: 100%;
    }

    .btn-removerForma {
        margin-left: 0px;
        margin-top: 5px;
    }

    #btn-adicionar {
        margin-bottom: 15px;
    }

    .my-button {
        margin-bottom: 5px;
    }
}

@media screen and (max-width: 600px) {
    .super-content {
        flex-direction: column;
    }

    .left-content {
        overflow: scroll;
    }

    .right-content {
        margin-top: 20px;
        overflow-x: scroll;
    }

    .left-content,
    .right-content {
        width: 100%;
    }

    .payment-form {
        flex-direction: column;
        width: 100%;
    }

    .form-field-pay {
        width: 90%;
    }

    .select-payMethod {
        width: 100%;
    }

    .select-payParc {
        width: 100%;
    }

    .btn-removerForma {
        margin-left: 0px;
        margin-top: 5px;
    }

    #btn-adicionar {
        margin-bottom: 15px;
    }

    .my-button {
        margin-bottom: 5px;
    }
}
</style>