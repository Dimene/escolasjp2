<template>
  <div>
    <ul class="nav nav-tabs">
      <li v-for="tipo in tipos" :key="tipo.id" class="nav-item">
        <a href="#" class="nav-link" :class="{active: tipo.id === ativo}" @click.prevent="selecionarTipo(tipo)">
          <i :class="['fa', tipo.icon, 'mr-2']"></i> {{ tipo.Descricao }}
        </a>
      </li>
    </ul>

    <sub-tabs-meses
      v-if="tipoSelecionado"
      :meses="tipoSelecionado.meses"
      :idtipo="tipoSelecionado.id"
      @selecionar="selecionarSubAba"
    />
  </div>
</template>

<script>
import SubTabsMeses from './SubTabsMeses.vue';

export default {
  props: ['tipos'],
  components: { SubTabsMeses },
  data() {
    return { ativo: null, tipoSelecionado: null };
  },
  methods: {
    selecionarTipo(tipo) {
      this.ativo = tipo.id;
      this.tipoSelecionado = tipo;
    },
    selecionarSubAba(payload) {
      this.$emit('selecionar-subaba', payload);
    }
  }
};
</script>
