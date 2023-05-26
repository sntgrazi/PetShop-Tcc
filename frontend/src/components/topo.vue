<template>
  <div class="row">
    <button @click="btnModal" id="open-modal">
      <i :class="['fa regular', icon]"></i>
      {{ botaoAdd }}
    </button>
  </div>
</template>

<script>
import Swal from "sweetalert2";
export default {
  name: "topo",
  props: ["type", "icon", "toggle"],
  data() {
    return {
      botaoAdd:
        this.type === "Clientes"
          ? "Novo Cliente"
          : this.type === "Pets"
            ? "Novo Pet"
            : "Novo Agendamento"
    };
  },
  methods: {
    btnModal() {
      if (this.type === "Pets") {
        Swal.fire({
          showCloseButton: true,
          title: "Já possui um tutor cadastrado?",
          showCancelButton: true,
          confirmButtonText: "Sim",
          cancelButtonText: "Não",
          cancelButtonColor: "red",
          allowOutsideClick: false
        }).then(result => {
          if (result.isConfirmed) {
            // Abrir modal para cadastrar novo pet
            this.toggle('info', null);
          } else if (result.dismiss === Swal.DismissReason.close) {
            // Nada a fazer, o modal foi fechado pelo botão de fechar
          } else {
            // Redirecionar para a tela de cadastro de clientes
            window.localStorage.setItem("redirecionado", "true");
            window.location.href = "/clientes";
          }
        });
      } else {
        this.toggle('info', null);
      }
    }
  }
};
</script>

<style>
.row {
  display: flex;
  justify-content: end;
}

#open-modal {
  padding: 0.6rem 1.2rem;
  background-color: #1e90ff;
  color: #fff;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1.1rem;
  margin-bottom: 15px;
  margin-right: 5px;
  transition: 0.2s all;
}

#open-modal i {
  font-size: 20px;
  margin-right: 10px;
}

#open-modal:active {
  transform: scale(0.95);
  box-shadow: 2px 2px var(--black);
}


@media screen and (max-width: 370px) {
  #open-modal {
    padding: 5px;
    width: 10em;
  }
}

@media screen and (max-width: 370px) {
  #open-modal {
    padding: 5px;
    width: 150px;
  }
}
</style>