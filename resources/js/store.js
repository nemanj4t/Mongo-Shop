export default {
    state: {
        products: []
    },
    getters: {
        returnProducts(state){
            return state.products;
        }
    },
    mutations: {
        CHANGE_PRODUCTS_FOR_SHOW: (state, products) => {
            state.products = products;
        }
    },
    actions: {
    }
}