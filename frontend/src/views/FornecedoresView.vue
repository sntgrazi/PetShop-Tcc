<template>
    <section>
        <div class="custom-container">
            <topo :type="'Fornecedor'" :icon="'fa-plus'" :toggle="toggleform" />
            <div class="custom-content">
                <div class="custom-main-content">
                    <ModalFornecedor v-if="formActive" :userId="userId" :toggle="toggleform" :tipo="'fornecedor'" :icon="'fa-user'"/>

                    
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import topo from "@/components/Outros/topo.vue";

import { ref } from 'vue';
import ModalFornecedor from '../components/modal/modalFornecedor.vue';
export default {
    name: 'FornecedoresView',
    components: {
        topo,
        ModalFornecedor,
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