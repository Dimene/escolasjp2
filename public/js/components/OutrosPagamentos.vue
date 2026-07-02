// public/js/OutrosPagamentos.js

// Componente TabsPagamentos
const TabsPagamentos = {
    props: ['tipos'],
    template: `
      <div class="mb-2">
        <button
          v-for="tipo in tipos"
          :key="tipo.idtipo"
          class="btn btn-outline-primary me-1 mb-1"
          @click="$emit('selecionar-subaba', tipo)"
        >
          {{ tipo.Descricao }}
        </button>
      </div>
    `
};

// Componente TabelaPagamentos
const TabelaPagamentos = {
    props: ['dados'],
    template: `
      <table class="table table-bordered mt-3" v-if="dados.length">
        <thead>
          <tr>
            <th>Mês</th>
            <th>Valor</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in dados" :key="item.id">
            <td>{{ item.mes }}</td>
            <td>{{ item.valor }}</td>
            <td>{{ item.status }}</td>
          </tr>
        </tbody>
      </table>
      <p v-else class="text-muted mt-3">Nenhum dado encontrado</p>
    `
};

// Componente principal
const OutrosPagamentos = {
    props: ['anolectivo', 'classes'],
    data() {
        return {
            selectedAno: this.anolectivo[0]?.id || null,
            selectedClasse: this.classes[0]?.id || null,
            tipos: [],
            dadosTabela: []
        };
    },
    components: { TabsPagamentos, TabelaPagamentos },
    template: `
      <div>
        <!-- Filtros -->
        <div class="row mb-2">
          <div class="col">
            <select v-model="selectedAno" @change="buscarTiposPagamento" class="form-control">
              <option v-for="ano in anolectivo" :value="ano.id">{{ ano.anolectivo }}</option>
            </select>
          </div>
          <div class="col">
            <select v-model="selectedClasse" @change="buscarTiposPagamento" class="form-control">
              <option v-for="classe in classes" :value="classe.id">{{ classe.Descricao }}</option>
            </select>
          </div>
        </div>

        <!-- Abas -->
        <tabs-pagamentos :tipos="tipos" @selecionar-subaba="carregarTabela"></tabs-pagamentos>

        <!-- Tabela -->
        <tabela-pagamentos :dados="dadosTabela"></tabela-pagamentos>
      </div>
    `,
    methods: {
        async buscarTiposPagamento() {
            if (!this.selectedAno || !this.selectedClasse) return;

            try {
                const url = `/RegistoAcademico/outrosPagamento/tipospagamentosShow/${this.selectedAno}/${this.selectedClasse}`;
                const response = await axios.get(url);
                this.tipos = response.data.tipos || [];
            } catch (err) {
                console.error('Erro ao buscar tipos de pagamento:', err);
            }
        },
        async carregarTabela(tipoSelecionado) {
            const { idtipo, idmes, idano, idclasse } = tipoSelecionado;
            if (!idtipo) return;

            try {
                const url = `/RegistoAcademico/outrosPagamento/show/${idano}/${idclasse}/${idtipo}/${idmes}`;
                const response = await axios.get(url);
                this.dadosTabela = response.data || [];
            } catch (err) {
                console.error('Erro ao carregar tabela:', err);
            }
        }
    },
    mounted() {
        this.buscarTiposPagamento();
    }
};

// Montar Vue
Vue.createApp({
    components: {
        'outros-pagamentos': OutrosPagamentos
    }
}).mount('#outrosPagamentosVue');
