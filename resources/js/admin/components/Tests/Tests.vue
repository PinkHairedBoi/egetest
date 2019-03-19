<style scoped>
.container .columns {
  margin: 1rem 1rem;
}
</style>

<template>
  <div>
    <loader :loading="inProgress"></loader>
    <div class="columns">
      <div class="column is-3">
        <router-link class="button is-primary is-alt is-large" :to="{name: 'testadd'}">Создать</router-link>
      </div>
      <div class="column is-6 has-text-centered">
        <p class="subtitle is-3">Тесты</p>
      </div>
      <div class="column is-3"></div>
    </div>
    <div class="columns">
      <div class="column">
        <div class="box content">
          <table class="table is-striped is-hoverable is-fullwidth">
            <thead>
              <tr>
                <th class="is-2"></th>
                <th class="is-2">
                  <abbr title="Порядок прохождения тестов">Порядок</abbr>
                </th>
                <th class="is-12">Название</th>
                <th class="is-1"></th>
              </tr>
            </thead>
            <tbody>
              <test v-for="test in orderedTests" :key="test.id" :test="test" @loading="loading" @update="update()"></test>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Test from "./Test";
import Loader from "../Loader";

export default {
  components: {
    Test,
    Loader
  },

  data() {
    return {
      inProgress: false,
      tests: []
    };
  },
  methods: {
    update() {
      this.inProgress = true;
      axios
        .get("/api/getTests")
        .then(response => {
          this.tests = Object.values(response.data);
          this.inProgress = false;
        })
        .catch(e => {
          this.inProgress = false;
        });
    },

    loading(e) {
      if (e == false) return this.update();
      this.inProgress = e;
    }
  },
  created() {
    this.update();
  },
  computed: {
    orderedTests: function()
    {
      return this.tests.sort((a, b) => a.order - b.order );
    }
  }
};
</script>