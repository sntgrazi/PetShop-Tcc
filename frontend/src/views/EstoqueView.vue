<template>
    <section>
        <div class="custom-container">
            <topo :type="'Estoque'" :icon="'fa-plus'" :toggle="toggleform" />
            <div class="custom-content">
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