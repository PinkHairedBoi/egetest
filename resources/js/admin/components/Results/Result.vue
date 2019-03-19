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
</style>


<template>
  <tr class="is-hoverable">
    <td>{{answer.user.name}}</td>
    <td>{{answer.created_at}}</td>
    <td>{{answer.attempt}}</td>
    <router-link class="clickable" :to="{name: 'qedit', params:{id: answer.question.id}}" tag="td">
      <span class="text">Вопрос #{{answer.question.id}}: {{answer.question.question}}</span>
    </router-link>
    <td
      :class="{'has-text-success': answer.is_right, 'has-text-danger': !answer.is_right}"
    >{{answer.is_right ? 'Верный' : 'Не верный'}}</td>
  </tr>
</template>

<script>
export default {
  props: {
    answer: Object
  }
};
</script>
