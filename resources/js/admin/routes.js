import VueRouter from 'vue-router';

let routes = [
    {path: '/admin/', component: require('./views/Dashboard').default, name: 'admin'},
    {path: '/admin/tests', component: require('./components/Tests/Tests').default, name: 'tests'},
    {path: '/admin/tests/add', component: require('./components/Tests/TestAdd').default, name: 'testadd'},
    {path: '/admin/tests/:id', component: require('./components/Tests/TestEdit').default, name: 'testedit'},
    
    {path: '/admin/questions', component: require('./components/Questions/Questions').default, name: 'questions'},
    {path: '/admin/questions/add', component: require('./components/Questions/QAdd').default, name: 'qadd'},
    {path: '/admin/questions/:id', component: require('./components/Questions/QEdit').default, name: 'qedit'},
    {path: '/admin/questions/copy/:id', component: require('./components/Questions/QCopy').default, name: 'qcopy'},

    {path: '/admin/users', component: require('./components/Users/Users').default, name: 'users'},
    {path: '/admin/users/add', component: require('./components/Users/UserAdd').default, name: 'useradd'},

    {path: '/admin/results', component: require('./components/Results/Results').default, name: 'results'},
];

export default new VueRouter({
    mode:'history',
    routes,
    linkActiveClass: 'is-active',
});