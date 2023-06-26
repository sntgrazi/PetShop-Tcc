<template>
    <section>
        <div class="custom-container">
            <topo :type="'Estoque'" :icon="'fa-plus'" :toggle="toggleform" />
            <div class="custom-content">
                <loading :loading="loading" />
                <div class="custom-main-content">
                    <tabela :topoTabela="topoTabela"  />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import tabela from '../components/Outros/tabela.vue';
import topo from '../components/Outros/topo.vue';
import { ref } from 'vue';
import modalProdutos from '../components/modal/modalProdutos.vue';
import ApiController from "@/ApiController";
import loading from '../components/Outros/loading.vue';
import Swal from 'sweetalert2';
import InfoProduto from '@/components/offCanvas/InfoProduto.vue';

export default {
    name: 'EstoqueView',
    components: {
        topo
    },
    data() {
        return {
            topoTabela: ['']
        }
    },
    mounted() {
        this.getAllProdutos();
        this.getAllServicos();

    },
    methods: {
        async getAllProdutos() {
            try {
                this.loading = true
                this.dadosTabela = []
                const produtos = await ApiController.buscarProdutos();
                this.dadosTabela = produtos;
                this.loading = false
            } catch (error) {
                console.log("Erro ao listar os produtos: ", error);
            }
        },
        async getAllServicos() {
            try {
                this.loading = true
                const servicos = await ApiController.getServicos();
                this.dadosTabelaServicos = servicos;
                this.loading = false
            } catch (error) {
                console.log("Erro ao listar os produtos: ", error);
            }
        },
        async deletarServico(id) {
            try {
                const result = await Swal.fire({
                    title: "Você tem certeza que deseja deletar este serviço?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim",
                    cancelButtonText: "Não",
                });

                if (result.isConfirmed) {
                    this.loading = true
                    await ApiController.deletarServico(id);
                    await this.getAllServicos()
                    this.loading = false
                    Swal.fire("", "Serviço deletado com sucesso", "success");
                }
            } catch (error) {
                console.error("Erro ao deletar o serviço: ", error);
            }
        },
        async deletarProduto(id) {
            try {
                const result = await Swal.fire({
                    title: "Você tem certeza que deseja deletar este produto?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim",
                    cancelButtonText: "Não",
                });

                if (result.isConfirmed) {
                    this.loading = true
                    $('#offcanvasRight').offcanvas('hide');
                    await ApiController.deletarProduto(id);
                    await this.getAllProdutos()
                    this.loading = false
                    Swal.fire("", "Produto deletado com sucesso", "success");
                }
            } catch (error) {
                console.error("Erro ao deletar o produto: ", error);
            }
        },
        async offcanvasProdutos(id) {
            try {
                this.loading = true
                this.produtos = await ApiController.getProdutoById(id);
                $('#offcanvasRight').offcanvas('show');
                this.loading = false
            } catch (error) {
                console.log("Erro ao procurar as informações do Produto: ", error);
            }

        },
    },
    setup() {
        const formActive = ref(false);
        const userId = ref(false);

        const toggleform = (tipo, id = false) => {
            formActive.value = !formActive.value;
            userId.value = false;

            if (id) {
                userId.value = id;
                console.log(userId.value);
            }
        };


        return {
            formActive,
            toggleform,
            userId,
        };
    },
}
</script>