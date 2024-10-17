import axios from 'axios';

import Swal from "sweetalert2";

const ApiUrl = 'https://apipetshop.sntapi.live/';

export default {


    async login(email, senha) {
        const url = `${ApiUrl}/`;
        const response = await axios.post(url, {
            email: email, senha: senha
        }).catch(error => {
            console.error('Erro ao tentar fazer login: ', error);
            throw error

        })
        const token = response.data;

        localStorage.setItem('token', token);

        Swal.fire({
            icon: 'success',
            title: 'Login feito com sucesso',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            },
            willClose: () => {
                window.location.href = '/agenda';
            }
        });
    },

    async autenticarSenha(email, senha) {
        const url = `${ApiUrl}/senhaAcesso`;
        const data = { email, senha };

        const response = await axios.post(url, data).catch(error => {
            Swal.fire({
                title: 'Senha incorreta!',
                icon: 'error',
            });
        })

        return response.data.senhaCorreta;
    },


    // Requisições Clientes

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

    async getClienteById(id) {
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

    // Requisição Animais

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

    async getAnimalById(id) {

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

    async buscarRaca(especie) {
        const url = `${ApiUrl}/buscarRaca/${especie}`
        const response = await axios.get(url)
            .catch(error => {
                console.error('Erro ao tentar buscar a raca: ', error);
                throw error;
            })

        return response.data;
    },

    // Requisição da Tabela de Relacionamento

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

    // Servicos

    async getServicos() {
        const url = `${ApiUrl}/servicos`;
        const response = await axios.get(url)
            .catch(error => {
                console.error("Erro ao buscar os servicos: ", error);
                throw error
            })

        return response.data;
    },

    async getServicosById(id) {
        const url = `${ApiUrl}/servicoById/${id}`;
        const response = await axios.get(url)
            .catch(error => {
                console.error("Erro ao buscar o servico: ", error);
                throw error
            })

        return response.data;
    },

    async cadastrarServico(servico) {
        const url = `${ApiUrl}/cadastrarServico`;
        const response = await axios.post(url, servico).catch(error => {
            console.error('Erro ao cadastrar um novo serviço: ', error);
            throw error;
        })

        return response.data;
    },

    async atualizarServico(id, servico) {
        const url = `${ApiUrl}/atualizarServico/${id}`;
        const response = await axios.put(url, servico).catch(error => {
            console.error(`Erro ao atualizar serviço com ID ${id}: `, error);
            throw error;
        })

        return response.data;
    },

    async deletarServico(id) {
        const url = `${ApiUrl}/deletarServico/${id}`
        const response = await axios.delete(url).catch(error => {
            console.error(`Erro ao deletar serviço com ID ${id}: `, error);
            throw error;
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
    async cadastrarFuncionario(funcionario) {

        const url = `${ApiUrl}/inserirFuncionario`;
        const response = await axios.post(url, funcionario)
            .catch(error => {
                console.error('Erro ao cadastrar um novo funcionário: ', error);
                throw error;
            })
        return response.data;
    },

    async getFuncionarioById(id) {
        const url = `${ApiUrl}/funcionario/${id}`;
        const response = await axios.get(url)
            .catch(error => {
                console.error('Erro ao buscar o funcionário: ', error);
                throw error;
            })
        return response.data;
    },

    async editarFuncionario(id, funcionarioAtualizado) {
        const url = `${ApiUrl}/updateFuncionario/${id}`;
        const response = await axios.put(url, funcionarioAtualizado)
            .catch(error => {
                console.error('Erro ao editar um funcionário: ', error);
                throw error;
            })
        return response.data;
    },

    async deletarFuncionario(id) {

        const url = `${ApiUrl}/deleteFuncionario/${id}`;
        const response = await axios.delete(url)
            .catch(error => {
                console.error('Erro ao tentar deletar um funcionário: ', error);
                throw error;
            })
        return response.data;
    },

    async getAllCargos() {
        const url = `${ApiUrl}/cargos`;
        const response = await axios.get(url)
            .catch(error => {
                console.error("Erro ao listar os Cargos: ", error);
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
    },

    async deleteOrdem(id) {
        const url = `${ApiUrl}/deleteOrdem/${id}`;
        const response = await axios.delete(url, id)
            .catch(error => {
                console.error('Erro ao tentar apagar o agendamento: ', error);
                throw error;
            })
        return response.data;
    },

    async updateOrdem(id, ordem) {
        const url = `${ApiUrl}/updateOrdem/${id}`;
        const response = await axios.put(url, ordem)
            .catch(error => {
                console.error('Erro ao tentar atualizar o agendamento: ', error);
                throw error;
            })
        return response.data;
    },

    async updateStatus(id, status) {
        const url = `${ApiUrl}/atualizarStatus/${id}`;
        const response = await axios.put(url, { status })
            .catch(error => {
                console.error('Erro ao tentar atualizar o status: ', error);
                throw error;
            })
        return response.data;
    },

    async buscarPortes() {
        const url = `${ApiUrl}/buscarPortes`;
        const response = await axios.get(url).catch(
            error => {
                console.error('Erro ao tentar buscar os portes: ', error);
                throw error;
            })

        return response.data
    },

    async buscarPelagens() {
        const url = `${ApiUrl}/buscarPelagens`;
        const response = await axios.get(url).catch(
            error => {
                console.error('Erro ao tentar buscar as pelagens: ', error);
                throw error;
            })

        return response.data
    },

    // Fornecedores 

    async getFornecedores() {
        const url = `${ApiUrl}/fornecedores`;
        const response = await axios.get(url).catch(error => {
            console.error('Erro ao buscar os fornecedores: ', error);
            throw error;
        })
        return response.data;
    },

    async cadastrarFornecedor(fornecedor) {
        const url = `${ApiUrl}/cadastrarFornecedores`;
        const response = await axios.post(url, fornecedor).catch(error => {
            console.error('Erro ao cadastrar um novo fornecedor: ', error);
            throw error;
        });

        return response.data;
    },

    async getFornecedorById(id) {
        const url = `${ApiUrl}/fornecedor/${id}`;
        const response = await axios.get(url).catch(error => {
            console.error(`Erro ao buscar fornecedor com ID ${id}: `, error);
            throw error;
        })

        return response.data;
    },

    async atualizarFornecedor(id, fornecedor) {
        const url = `${ApiUrl}/atualizarFornecedor/${id}`;
        const response = await axios.put(url, fornecedor).catch(error => {
            console.error(`Erro ao atualizar fornecedor com ID ${id}: `, error);
            throw error;
        })

        return response.data;
    },

    async deletarFornecedor(id) {
        const url = `${ApiUrl}/deletarFornecedor/${id}`;
        const response = await axios.delete(url).catch(error => {
            console.error(`Erro ao deletar fornecedor com ID ${id}: `, error);
            throw error;
        })

        return response.data;
    },

    // Produtos 

    async buscarProdutos() {
        const url = `${ApiUrl}/Allprodutos`;
        const response = await axios.get(url).catch(error => {
            console.error('Erro ao tentar buscar os produtos: ', error);
            throw error;
        })

        return response.data;
    },

    async buscarProdutosCod(cod) {
        const url = `${ApiUrl}/produtoCod/${cod}`;
        const response = await axios.get(url).catch(error => {
            console.error('Erro ao tentar buscar o produtos: ', error);
            throw error;
        })

        return response.data[0];
    },

    async cadastrarProduto(produto) {
        const url = `${ApiUrl}/cadastrarProduto`;
        const config = {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        };
        const response = await axios.post(url, produto, config).catch(error => {
            console.error('Erro ao cadastrar um novo produto: ', error);
            throw error;
        })

        return response.data;
    },

    async atualizarProduto(id, produto) {
        const url = `${ApiUrl}/atualizarProduto/${id}`;
        const response = await axios.put(url, produto).catch(error => {
            console.error(`Erro ao atualizar produto com ID ${id}: `, error);
            throw error;
        })

        return response.data;
    },

    async deletarProduto(id) {
        const url = `${ApiUrl}/deletarProduto/${id}`;
        const response = await axios.delete(url).catch(error => {
            console.error(`Erro ao deletar produto com ID ${id}: `, error);
            throw error;
        })

        return response.data;
    },

    async getProdutoById(id) {
        const url = `${ApiUrl}/produto/${id}`;
        const response = await axios.get(url).catch(error => {
            console.error(`Erro ao buscar produto com ID ${id}: `, error);
            throw error;
        })

        return response.data;
    },

    async cadastrarVenda(venda) {
        const url = `${ApiUrl}/venda`;
        const response = await axios.post(url,venda).catch(error => {
            console.error(`Erro ao tentar realizar a venda: `, error);
            throw error;
        })

        return response.data;
    },

    async historico() {
        const url = `${ApiUrl}/historico-vendas`;
        const response = await axios.get(url).catch(error => {
            console.error(`Erro ao tentar buscar o: `, error);
            throw error;
        })

        return response.data;
    }

}