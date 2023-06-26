<template>
    <section>
        <div class="custom-container">
            <topo :type="'Funcionario'" :icon="'fa-plus'" :toggle="toggleform" />
            <div class="custom-content">
                <div class="custom-main-content">
                    <loading :loading="loading" />
                    <modalFuncionario v-if="formActive" :userId="userId" :icon="'fa-user'" :toggle="toggleform"
                        @atualizarTabela="getFuncionarios" />
                    <tabela :topoTabela="topoTabela" :tipo="'funcionario'" :dados="dadosTabela"
                        @infoFuncionario="offcanvasFuncionario" />

                    <InfoFuncionario :funcionario="funcionario" :toggle="toggleform" @deletar="deletarFuncionario" />
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
import InfoFuncionario from '@/components/offCanvas/InfoFuncionario.vue';
import loading from '@/components/Outros/loading.vue';
import Swal from 'sweetalert2';

export default {
    name: 'FuncionarioView',
    components: {
        topo,
        tabela,
        modalFuncionario,
        InfoFuncionario,
        loading
    },
    data() {
        return {
            topoTabela: ['ID', 'NOME', 'CPF', 'TELEFONE', 'CARGO'],
            dadosTabela: [],
            funcionario: [],
            loading: true
        }
    },
    methods: {
        async getFuncionarios() {
            try {
                this.loading = true
                this.dadosTabela = await ApiController.getFuncionarios();
                this.loading = false
            } catch (error) {
                console.log('Erro ao listar os funcioanrios: ', error)
            }
        },
        async offcanvasFuncionario(id) {
            try {
                this.loading = true
                const informacoesFuncionario = await ApiController.getFuncionarioById(id)
                this.funcionario = informacoesFuncionario
                this.endereco = informacoesFuncionario.endereco.split(",");
                this.funcionario.cep = this.endereco[0];
                this.funcionario.bairro = this.endereco[1];
                this.funcionario.rua = this.endereco[2];
                this.funcionario.cidade = this.endereco[3];
                this.funcionario.uf = this.endereco[4];
                this.funcionario.n_casa = this.endereco[5];
                $('#offcanvasRight').offcanvas('show');
                this.loading = false
            } catch (error) {
                console.log("Erro ao procurar as informações do Funcionario: ", error);
            }

        },
        async deletarFuncionario(funcionarioId) {
            try {
                const result = await Swal.fire({
                    title: "Você tem certeza que deseja deletar este funcionário?",
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
                    await ApiController.deletarFuncionario(funcionarioId);
                    await this.getFuncionarios();
                    this.loading = false
                    Swal.fire("", "Funcionário deletado com sucesso", "success");
                }
            } catch (error) {
                console.error("Erro ao deletar o cliente: ", error);
            }
        },
    },
    mounted() {
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