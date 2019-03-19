<style scoped>
.right {
  text-align: right;
}
.clickable {
  cursor: pointer;
  max-width: 8em;
  max-height: 10em;
}

.text {
  display: block;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}

.image {
  display: inline;
  margin: 0 5px;
}
</style>


<template>
  <tr class="is-hoverable">
    <td>{{question.id}}</td>
    <router-link class="clickable" :to="{name: 'qedit', params:{id: question.id}}" tag="td">
      <span class="text">{{question.question}}</span>
    </router-link>
    <router-link class="clickable" :to="{name: 'qedit', params:{id: question.id}}" tag="td">
      <span class="text">{{question.answer}}</span>
    </router-link>
    <router-link class="clickable" :to="{name: 'qedit', params:{id: question.id}}" tag="td">
      <img class="image is-64x64" v-for="image in question.images" :key="image.id" :src="image.src">
    </router-link>
    <td class="right">
      <router-link class="icon" :to="{name: 'qcopy', params:{id: question.id}}">
        <i class="fa fa-clone 2x" aria-hidden="true"></i>
      </router-link>
      <a class="icon" @click="remove()">
        <i class="fa fa-trash-o 2x" aria-hidden="true"></i>
      </a>
    </td>
  </tr>
</template>

<script>
export default {
  props: {
    question: Object
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
      axios.delete("/api/questions/" + this.question.id).then(response => {
        this.$emit("loading", false);
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
