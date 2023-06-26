<template>
    <section>
        <div class="custom-container">
            <topo :type="'Fornecedor'" :icon="'fa-plus'" :toggle="toggleform" />
            <div class="custom-content">
                <loading :loading="loading" />
                <div class="custom-main-content">
              
                    <ModalFornecedor v-if="formActive" :userId="userId" :toggle="toggleform" :tipo="'fornecedor'" :icon="'fa-user'"/>
                    <ModalFornecedor v-if="formActive" :userId="userId" :toggle="toggleform" :tipo="'fornecedor'"
                        :icon="'fa-user'" @atualizarTabela="buscarFornecedores"/>

                    <tabela :dados="dadosTabela" :topoTabela="topoTabela" :tipo="'fornecedor'"
                        :toggle="toggleform" @deletar="deletarFornecedor"/>


                </div>
            </div>
        </div>
    </section>
</template>
<script>
import topo from "@/components/Outros/topo.vue";
import { ref } from 'vue';
import ModalFornecedor from '../components/modal/modalFornecedor.vue';
import tabela from "@/components/Outros/tabela.vue";
import ApiController from "@/ApiController";
import Swal from "sweetalert2";
import loading from "@/components/Outros/loading.vue";

export default {
    name: 'FornecedoresView',
    components: {
        topo,
        ModalFornecedor,
        tabela,
        loading
    },
    data() {
        return {
            dadosTabela: [],
            topoTabela: ['ID', 'NOME', 'CNPJ', 'TELEFONE', 'EMAIL', 'AÇÕES'],
            fornecedor: [],
            loading: true
        }
    },
    methods: {
        async buscarFornecedores() {
            try {
                this.loading = true
                const fornecedor = await ApiController.getFornecedores();
                this.dadosTabela = fornecedor;
                this.loading = false
            } catch (error) {
                console.log(error)
            }
        },
        async deletarFornecedor(id) {
            try {
                const result = await Swal.fire({
                    title: "Você tem certeza que deseja deletar este fornecedor?",
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
                    await ApiController.deletarFornecedor(id);
                    await this.buscarFornecedores();
                    this.loading = false
                    Swal.fire("", "Fornecedor deletado com sucesso", "success");
                }
            } catch (error) {
                console.error("Erro ao deletar o Fornecedor: ", error);
            }
        }
    },
    mounted() {
        this.buscarFornecedores();
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