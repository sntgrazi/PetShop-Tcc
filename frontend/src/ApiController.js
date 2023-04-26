import axios from 'axios';

const ApiUrl = 'http://localhost:84';

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
            const url = `${ApiUrl}/inserir`;
            const response = await axios.post(url, cliente);
            return response.data
        } catch (error){
            console.error('Erro ao inserir novo cliente: ', error);
            throw error;
        }
    }
}