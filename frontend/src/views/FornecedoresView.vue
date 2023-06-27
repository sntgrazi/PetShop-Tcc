<template>
    <section>
        <div class="custom-container">
            <topo :type="'Fornecedor'" :icon="'fa-plus'" :toggle="toggleform" />
            <div class="custom-content">
                <div class="custom-main-content">
                    <ModalFornecedor v-if="formActive" :userId="userId" :toggle="toggleform" :tipo="'fornecedor'" :icon="'fa-truck-field'"/>

                    <tabela :dados="dadosTabela" :topoTabela="topoTabela"
                    :tipo="'fornecedor'"/>
                    
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

export default {
    name: 'FornecedoresView',
    components: {
        topo,
        ModalFornecedor,
        tabela
    },
    data(){
        return{
            topoTabela: ['ID', 'NOME', 'CNPJ', 'TELEFONE'],
            dadosTabela: []
        }
    },
    methods: {
        async getAllFornecedores(){
            try{    
                this.loading = true
                const fornecedores = await ApiController.getFornecedores();
                this.dadosTabela = fornecedores;
                console.log(this.dadosTabela)
                this.loading = false
            }catch (error){
                console.log('Erro ao buscar os fornecedores: ', error)
            }
        }
    },
    mounted(){
        this.getAllFornecedores();
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