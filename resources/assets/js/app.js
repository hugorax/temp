
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('controlparqueo', require('./components/controlCar.vue').default);

// Vue.config.devtools = true;
// Vue.config.debug = true;
// Vue.config.silent = true; 

const app = new Vue({
    el: '#app'
});

toastr = require('toastr');
toastr.options.progressBar = true;
toastr.options.showMethod = 'slideDown';
toastr.options.closeMethod = 'slideUp';


window.tocatch = (er, msj="No se pudo realizar el proceso", tipo="error" )=>{
    
    if(er.response && er.response.status == 422) {
        let err =  er.response.data.errors;
            for (let field of Object.keys(err)) {
                    let mm = ' '+err[field][0]
                    toastr.error(mm, 'error');
                }
    }
    toastr.error(msj, tipo);
}


window.dd =(st)=>{
    console.log(st)
}

window.isValidDate =(fecha)=>{
    return new Date(fecha).toString() !== 'Invalid Date';
}