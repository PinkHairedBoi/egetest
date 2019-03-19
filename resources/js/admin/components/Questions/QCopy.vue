<template>
  <div>
    <div class="modal is-active">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Копировать вопрос с ID {{q_id}}.</p>
          <router-link tag="button" class="delete" aria-label="close" :to="{name:'questions'}"></router-link>
        </header>
        <section class="modal-card-body" style="height: 400px;">
          <div class="field">
            <b-dropdown v-model="test_id">
              <button class="button" type="button" slot="trigger">
                <span v-if="test">{{test.name}}</span>
                <span v-else>Выберите тест</span>
                <b-icon icon="caret-down"></b-icon>
              </button>
              <b-dropdown-item
                v-for="test in tests"
                :key="test.order"
                :value="test.id"
              >{{test.name}}</b-dropdown-item>
            </b-dropdown>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success" @click="copyQ()">Копировать</button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      test_id: 0,
      q_id: 0,
      tests: []
    };
  },
  methods: {
    back() {
      this.$router.push({
        name: "questions"
      });
    },
    copyQ() {
      if (!this.test_id) return;
      axios
        .post("/api/questions/copy", {test_id: this.test_id, id: this.q_id })
        .then(response => {
          this.back();
        });
    }
  },
  mounted() {
    this.q_id = this.$route.params.id;
    axios.get("/api/getTests").then(response => {
      this.tests = Object.values(response.data);
    });
  },
  computed:
  {
    test: function()
    {
      return this.tests.find(e => {
        return e.id == this.test_id});
    }
  }
};
</script>