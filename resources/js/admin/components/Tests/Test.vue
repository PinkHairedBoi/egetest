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
    <th>
      <a class="icon" @click="moveUp()">
        <i v-if="test.order > 1" class="fa fa-caret-up fa-2x" aria-hidden="true"></i>
      </a>
      <a class="icon" @click="moveDown()">
        <i v-if="test.order < testNumber" class="fa fa-caret-down fa-2x" aria-hidden="true"></i>
      </a>
    </th>

    <td>{{test.order}}</td>
    <router-link
      class="clickable"
      :to="{name: 'testedit', params:{id: test.id}}"
      tag="td"
    >{{test.name}}</router-link>
    <td class="right">
      <a class="icon" @click="remove()">
        <i class="fa fa-trash-o 2x" aria-hidden="true"></i>
      </a>
    </td>
  </tr>
</template>

<script>
export default {
  props: {
    test: Object
  },
  methods: {
    moveUp() {
      this.move(-1);
    },

    moveDown() {
      this.move(1);
    },

    move(side) {
      this.$emit("loading", true);
      axios
        .post("/api/tests/move", {
          oldorder: this.test.order,
          neworder: this.test.order + side
        })
        .then(response => {
          this.$emit("loading", false);
        });
    },

    remove() {
      this.$emit("loading", true);
      axios.delete("/api/tests/" + this.test.id).then(response => {
        this.$emit("loading", false);
        this.$emit('update');
      });
    }
  },
  computed: {
    testNumber: function() {
      return this.$parent.tests.length;
    }
  }
};
</script>
