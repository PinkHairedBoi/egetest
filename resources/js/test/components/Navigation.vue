<template>
  <nav class="navbar is-white topNav" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <a class="navbar-item" href="/">
        <img src="/logo.png" width="112" height="28">
      </a>
      
      <a
        role="button"
        class="navbar-burger burger"
        aria-label="menu"
        aria-expanded="false"
        data-target="navbar"
        @click="isOpen = !isOpen"
        v-bind:class="{'is-active': isOpen}"
      >
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>
    <div id="navbar" class="navbar-menu" v-bind:class="{'is-active': isOpen}">
      <div class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <a class="button subtitle">Вы вошли в систему, {{user.name}}</a>
            <a class="button is-light" v-if="user.admin" href="/admin">В админку</a>
            <a class="button is-light" href="/api/logout">Выйти</a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  props: {
    user: Object
  },
  data() {
    return {
      isOpen: false
    };
  }
};
</script>
