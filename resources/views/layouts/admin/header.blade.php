<nav class="navbar is-white topNav" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ url('/') }}">
                <img src="{{ url('/logo.png') }}" width="112" height="28">
              </a>

        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbar" @click="isOpen = !isOpen" v-bind:class="{'is-active': isOpen}">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
              </a>
    </div>
    <div id="navbar" class="navbar-menu" v-bind:class="{'is-active': isOpen}">
        <div class="navbar-start">
            @include('layouts.admin.nav')
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-light" href="{{ url('/test') }}">В тест</a>
                    <a class="button is-light" href="{{ url('/api/logout') }}">Выйти</a>
                </div>
            </div>
        </div>
    </div>
</nav>