
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.ko = require('knockout');

import * as exampleComponent from './components/example-component';

ko.components.register('example', {
    viewModel: exampleComponent.ReservationsViewModel,
    template: require('./components/example-component.html')
});

ko.applyBindings();