<template>
  <ul class="nav nav-pills mb-3">
    <li v-for="mes in meses" :key="mes.id" class="nav-item">
      <a href="#" class="nav-link" :class="{active: mes.id === ativo}"
         @click.prevent="selecionarMes(mes)">
        {{ mes.nome }}
      </a>
    </li>
  </ul>
</template>

<script>
export default {
  props: ['meses', 'idtipo'],
  data() {
    return { ativo: null };
  },
  methods: {
    selecionarMes(mes) {
      this.ativo = mes.id;
      this.$emit('selecionar', {
        idtipo: this.idtipo,
        idmes: mes.id,
        idano: mes.anolectivo_id,
        idclasse: mes.classe_id
      });
    }
  }
};
</script>
