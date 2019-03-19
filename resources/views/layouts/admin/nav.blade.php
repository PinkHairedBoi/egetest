<div class="navbar-item has-dropdown is-hoverable">
    <router-link class="navbar-item" to="/" exact>Главная (наведи)</router-link>
    <div class="navbar-dropdown">
        Потом сделаю красивую информативную табличку о результатах учеников с графиками (активность и прочее)
    </div>
</div>
<router-link class="navbar-item" :to="{name: 'users'}">
    Пользователи
</router-link>
<router-link class="navbar-item" :to="{name: 'tests'}">
    Тесты
</router-link>
<router-link class="navbar-item" :to="{name: 'questions'}" exact>
    Вопросы
</router-link>
<router-link class="navbar-item" :to="{name: 'results'}" exact>
    Результаты
</router-link>