<template>
    <div class="modal is-active" v-if="loading">
      <div class="modal-background"></div>
      <div class="box">
        <i class="fa fa-spinner fa-spin fa-4x" aria-hidden="true"></i>
      </div>
    </div>
</template>

<script>
export default {
  props: ['loading']
}
</script>
