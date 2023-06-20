<template>
    <section>
        <div class="custom-container">
            <topo :type="'Funcionario'" :icon="'fa-plus'" :toggle="toggleform" />
            <div class="custom-content">
                <div class="custom-main-content">
                    <modalFuncionario v-if="formActive" :userId="userId" :icon="'fa-user'" :toggle="toggleform"/>  
                    <tabela :topoTabela="topoTabela" :tipo="'funcionario'" :dados="dadosTabela"/>
                </div>
            </div>
        </div>
    </section>
</template> 

<script>
import tabela from '../components/Outros/tabela.vue';
import ApiController from '@/ApiController';
import modalFuncionario from '@/components/modal/modalFuncionario.vue';
import topo from '../components/Outros/topo.vue';
import { ref } from 'vue';

export default {
    name: 'FuncionarioView',
    components: {
        topo,
        tabela,
        modalFuncionario
    },
    data(){
        return{
            topoTabela: ['ID','NOME', 'CPF', 'TELEFONE', 'CARGO'],
            dadosTabela: []
        }
    },
    methods: {
        async getFuncionarios(){
            try{
                this.dadosTabela = await ApiController.getFuncionarios();
            }catch (error){
                console.log('Erro ao listar os funcioanrios: ', error)
            }
        }
    },
    mounted(){
        this.getFuncionarios()
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