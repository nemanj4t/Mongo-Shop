export default {
    state: {
        products: [],
        shopping_cart: {
            items: 0,
            products: [],
            price: 0
        }
    },
    getters: {
        returnProducts(state){
            return state.products;
        },

        returnShoppingCart(state){
            return state.shopping_cart;
        }
    },
    mutations: {
        CHANGE_PRODUCTS_FOR_SHOW: (state, products) => {
            state.products = products;
        },

        ADD_PRODUCT_TO_CART: (state, product) => {
            state.shopping_cart.products.push(product);
            state.shopping_cart.items += 1;
        }
    },
    actions: {
    }
}