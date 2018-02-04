/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import Vue from 'vue'
import Vuex from 'vuex';
import vuexI18n from 'vuex-i18n';
import Locales from './vue-i18n-locales.generated.js';

Vue.use(Vuex);
const store = new Vuex.Store();
Vue.use(vuexI18n.plugin, store);
Vue.i18n.add('en', Locales.en);
Vue.i18n.add('nl', Locales.nl);
Vue.i18n.add('fr', Locales.fr);
Vue.i18n.set('en');

/**
 * Dev tools disabled when in production when compiling to production
 */
Vue.config.devtools = process.env.NODE_ENV !== 'production';
Vue.config.debug = process.env.NODE_ENV !== 'production';
Vue.config.silent = process.env.NODE_ENV === 'production';

window.daterangepicker = require('daterangepicker');

require('./custom');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('person-form', require('./components/PersonForm.vue'));

window.onload = function () {
    window.App = new Vue({
        store,
        el: '#peopleContainer',
        data: {
            people: [{destroyed: false}]
        },
        computed: {
            lastVisableIndex: function () {
                var indexLast = 0;
                for (var i = 0; i < this.people.length; i++) {
                    if (!this.people[i].destroyed) {
                        indexLast = i;
                    }
                }
                return indexLast;
            }
        },
        methods: {
            addPerson: function (e) {
                this.people.push({destroyed: false});
            },
            deletePerson: function (index) {
                this.people[index].destroyed = true;
            }
        }
    });
};