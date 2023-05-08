import axios from 'axios';

const ApiUrl = 'https://petshoptcc.ew.r.appspot.com';

export default{
    async getClientes(){
        try{
            const url = `${ApiUrl}/clientes`;
            const response = await axios.get(url);
            return response.data
        } catch (error){
            console.error('Erro ao buscar os clientes: ', error);
            throw error;
        }
        
    },

    async cadastrarCliente(cliente){
        try{
            const url = `${ApiUrl}/inserirCliente`;
            const response = await axios.post(url, cliente);
            return response.data
        } catch (error){
            console.error('Erro ao inserir novo cliente: ', error);
            throw error;
        }
    },

    async cliente(id){
        try{
            const url = `${ApiUrl}/cliente/${id}`;
            const response = await axios.get(url);
            return response.data
        } catch (error){
            console.error('Erro ao buscar o cliente: ', error);
            throw error;
        }
    },

    async editarCliente(id, clienteAtualizado){
        try{
            const url = `${ApiUrl}/updateCliente/${id}`;
            const response = await axios.put(url, clienteAtualizado);
            return response.data;
        }catch(error){
            console.error('Erro ao atualizar o cliente: ', error);
        }
    },

    async deletarCliente(id) {
        try {
          const url = `${ApiUrl}/deleteCliente/${id}`;
          const response = await axios.delete(url);
          return response.data;
        } catch (error) {
          console.error('Erro ao deletar o cliente: ', error);
        }
    },

    // Animais Rotas

    async inserirAnimal(animal){
        try{
            const url = `${ApiUrl}/inserirAnimal`;
            const response = await axios.post(url, animal);
            return response.data
        } catch (error){
            console.error('Erro ao inserir novo animal: ', error);
            throw error;
        }
    }

}