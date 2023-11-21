import { createRouter, createWebHistory } from "vue-router";

import invoiceIndex from '../components/Invoice/Index.vue';
import createNewInvoice from '../components/Invoice/CreateInvoice.vue';
import showInvoice from '../components/Invoice/showInvoice.vue';
import editInvoice from '../components/Invoice/editInvoice.vue';
import notFound from '../components/NotFound.vue';

const routes = [
    {
        path: '/',
        component:invoiceIndex
    },
    {
        path: '/invoice/new',
        component : createNewInvoice
    },
    {
        path: '/invoice/show/:id',
        component: showInvoice,
        props: true
    },
    {
        path: '/invoice/edit/:id',
        component: editInvoice,
        props: true
    },
    {
        path: '/:pathMatch(.*)*',
        component:notFound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;