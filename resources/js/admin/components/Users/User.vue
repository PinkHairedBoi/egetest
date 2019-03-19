
<style scoped>
.right {
  text-align: right;
}
.clickable {
  cursor: pointer;
}
</style>


<template>
  <tr class="is-hoverable">
    <td>{{user.name}}</td>
    <td>{{user.name}}</td>
    <td>
      <b-dropdown v-model="test">
        <button class="button" type="button" slot="trigger">
          <span v-if="test">{{test.name}}</span>
          <span v-else>Тест не выбран</span>
          <b-icon icon="caret-down"></b-icon>
        </button>
        <b-dropdown-item v-for="test in tests" :key="test.id" :value="test">{{test.name}}</b-dropdown-item>
      </b-dropdown>
    </td>
    <td class>
      <a class="icon" @click="remove()">
        <i class="fa fa-trash-o 2x" aria-hidden="true"></i>
      </a>
    </td>
  </tr>
</template>

<script>
export default {
  props: {
    user: Object,
    tests: Array
  },
  methods: {
    remove() {
      this.$emit("loading", true);
      axios.delete("/api/users/" + this.user.id).then(response => {
        this.$emit("loading", false);
      });
    }
  },
  computed: {
    test: {
      get: function() {
        return this.tests.find(e => {
          return this.user.test_id == e.id;
        });
      },
      set: function(test) {
        axios
          .patch("/api/users/" + this.user.id, { test_id: test.id });
          this.user.test_id = test.id;
      }
    }
  }
};
</script>
