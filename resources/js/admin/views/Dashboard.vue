<template>
  <div>
      Загрузка...
  </div>
</template>
<script>
export default {
  created () {
    this.$router.push(
      {name: 'users'}
    )
  }
}
</script>
