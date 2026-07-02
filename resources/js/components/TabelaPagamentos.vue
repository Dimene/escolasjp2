<template>
  <div class="container-tabela">
    <h3 class="titulo-tabela">
      <i class="fa fa-users"></i>
      Lista de pagamentos
    </h3>
    <table class="table table-striped table-bordered nowrap">
      <thead>
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>Turma</th>
          <th>Estado</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in dados" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.nome }}</td>
          <td>{{ item.turma }}</td>
          <td>{{ item.estado }}</td>
          <td>
            <button class="btn btn-sm btn-primary">Gerenciar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: ['dados']
};
</script>
