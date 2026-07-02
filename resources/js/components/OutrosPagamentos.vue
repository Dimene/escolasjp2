<template>
  <div>
    <!-- Filtros -->
    <div class="row mb-2">
      <div class="col">
        <select v-model="selectedAno" @change="buscarTiposPagamento" class="form-control">
          <option v-for="ano in anolectivo" :value="ano.id" :key="ano.id">{{ ano.anolectivo }}</option>
        </select>
      </div>
      <div class="col">
        <select v-model="selectedClasse" @change="buscarTiposPagamento" class="form-control">
          <option v-for="classe in classes" :value="classe.id" :key="classe.id">{{ classe.Descricao }}</option>
        </select>
      </div>
    </div>

    <!-- Abas -->
    <tabs-pagamentos :tipos="tipos" @selecionar-subaba="carregarTabela" />

    <!-- Tabela -->
    <tabela-pagamentos :dados="dadosTabela" />
  </div>
</template>

<script>
import TabsPagamentos from './TabsPagamentos.vue';
import TabelaPagamentos from './TabelaPagamentos.vue';
import axios from 'axios';

export default {
  props: {
    anolectivo: Array,
    classes: Array
  },
  components: { TabsPagamentos, TabelaPagamentos },
  data() {
    return {
      selectedAno: null,
      selectedClasse: null,
      tipos: [],
      dadosTabela: []
    };
  },
  methods: {
    async buscarTiposPagamento() {
      const url = `/RegistoAcademico/outrosPagamento/tipospagamentosShow/${this.selectedAno}/${this.selectedClasse}`;
      const response = await axios.get(url);
      this.tipos = response.data.tipos; // ajuste conforme retorno
    },
    async carregarTabela({ idtipo, idmes, idano, idclasse }) {
      const url = `/RegistoAcademico/outrosPagamento/show/${idano}/${idclasse}/${idtipo}/${idmes}`;
      const response = await axios.get(url);
      this.dadosTabela = response.data;
    }
  },
  mounted() {
    this.selectedAno = this.anolectivo[0]?.id;
    this.selectedClasse = this.classes[0]?.id;
    this.buscarTiposPagamento();
  }
};
</script>
