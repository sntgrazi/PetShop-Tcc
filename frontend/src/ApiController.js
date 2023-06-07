import axios from 'axios';

const ApiUrl = 'https://petshoptcc.ew.r.appspot.com';

export default {

    async getClientes() {
        const url = `${ApiUrl}/clientes`;
        const response = await axios.get(url)
            .catch(error => {
                console.error('Erro ao buscar os clientes: ', error);
                throw error;
            })
        return response.data;
    },

    async cadastrarCliente(cliente) {

        const url = `${ApiUrl}/inserirCliente`;
        const response = await axios.post(url, cliente)
            .catch(error => {
                console.error('Erro ao cadastrar um novo cliente: ', error);
                throw error;
            })
        return response.data;
    },

    async cliente(id) {
        const url = `${ApiUrl}/cliente/${id}`;
        const response = await axios.get(url)
            .catch(error => {
                console.error('Erro ao buscar o cliente: ', error);
                throw error;
            })
        return response.data;
    },

    async editarCliente(id, clienteAtualizado) {
        const url = `${ApiUrl}/updateCliente/${id}`;
        const response = await axios.put(url, clienteAtualizado)
            .catch(error => {
                console.error('Erro ao editar um clientes: ', error);
                throw error;
            })
        return response.data;
    },

    async deletarCliente(id) {

        const url = `${ApiUrl}/deleteCliente/${id}`;
        const response = await axios.delete(url)
            .catch(error => {
                console.error('Erro ao tentar deletar um cliente: ', error);
                throw error;
            })
        return response.data;
    },

    // Animais Rotas

    async cadastrarAnimal(animal) {

        const url = `${ApiUrl}/inserirAnimal`;
        const response = await axios.post(url, animal)
            .catch(error => {
                console.error('Erro ao cadastrar um novo animal: ', error);
                throw error;
            })
        return response.data;
    },

    async getAnimais() {

        const url = `${ApiUrl}/animais`;
        const response = await axios.get(url)
            .catch(error => {
                console.error('Erro ao buscar os animais: ', error);
                throw error;
            })
        return response.data;

    },

    async animal(id) {

        const url = `${ApiUrl}/animal/${id}`;
        const response = await axios.get(url)
            .catch(error => {
                console.error('Erro ao buscar o animal: ', error);
                throw error;
            })
        return response.data;

    },

    async editarAnimal(id, animalAtualizado) {
        const url = `${ApiUrl}/updateAnimal/${id}`;
        const response = await axios.put(url, animalAtualizado)
            .catch(error => {
                console.error('Erro ao editar o animal: ', error);
                throw error;
            })
        return response.data;
    },

    async deletarAnimal(id) {

        const url = `${ApiUrl}/deleteAnimal/${id}`;
        const response = await axios.delete(url)
            .catch(error => {
                console.error('Erro ao tentar deletar o animal: ', error);
                throw error;
            })
        return response.data;
    },

    // Tabela de Relacionamento Cliente_Animal

    async getclienteVinculado(id) {

        const url = `${ApiUrl}/clientevinculado/${id}`;
        const response = await axios.get(url)
            .catch(error => {
                console.error('Erro ao buscar os tutores vinculados: ', error);
                throw error;
            })
        return response.data;
    },

    async getpetVinculado(id) {

        const url = `${ApiUrl}/animalvinculado/${id}`;
        const response = await axios.get(url)
            .catch(error => {
                console.error('Erro ao buscar os animais vinculados: ', error);
                throw error;
            })
        return response.data;
    },

    async buscarClienteTabela() {
        const url = `${ApiUrl}/buscarClienteTabela`;
        const response = await axios.get(url)
            .catch(error => {
                console.error('Erro ao buscar os clientes: ', error);
                throw error;
            })

        return response.data;
    },

    async deletarVinculo(cliente_id, animal_id) {

        const url = `${ApiUrl}/deletevinculo/${cliente_id}/${animal_id}`;
        const response = await axios.delete(url, cliente_id, animal_id)
            .catch(error => {
                console.error('Erro ao tentar remover o vinculo: ', error);
                throw error;
            })
        return response.data;

    },

    async adicionarVinculo(cliente_id, animal_id) {

        const url = `${ApiUrl}/adicionarvinculo`;
        const response = await axios.post(url, { cliente_id, animal_id })
            .catch(error => {
                console.error('Erro ao buscar os clientes: ', error);
                throw error;
            })
        return response.data;
    },

    // Buscar Servicos

    async getServicos() {
        const url = `${ApiUrl}/servicos`;
        const response = await axios.get(url)
            .catch(error => {
                console.error("Erro ao buscar os servicos: ", error);
                throw error
            })

        return response.data;
    },

    // Funcionarios

    async getFuncionarios() {
        const url = `${ApiUrl}/funcionarios`;
        const response = await axios.get(url)
            .catch(error => {
                console.error("Erro ao buscar os funcionários: ", error);
                throw error
            })

        return response.data;
    },

    //Ordem de servico

    async getOrdensById(id) {
        const url = `${ApiUrl}/ordem/${id}`;
        const response = await axios.get(url, id).catch(
            error => {
                console.error("Erro ao buscar a ordem de serviço: ", error);
                throw error;
            }
        )
        return response.data
    },
    async getAllOrdens() {
        const url = `${ApiUrl}/Allordens`;
        const response = await axios.get(url).catch(
            error => {
                console.error("Erro ao buscar as Ordens de Serviços: ", error);
                throw error;
            }
        )
        return response.data
    },

    async inserirOrdem(ordem) {
        const url = `${ApiUrl}/inserirOrdem`;
        const response = await axios.post(url, ordem)
            .catch(error => {
                console.error("Erro ao tentar cadastrar a Ordem de Serviço: ", error);
                throw error;
            })

        return response.data;
    }

}