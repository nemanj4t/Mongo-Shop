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
            state.shopping_cart.price += parseFloat(product.Cena);
        },

        REMOVE_PRODUCT_FROM_CART: (state, product) => {
            let index = state.shopping_cart.products.indexOf(product);
            state.shopping_cart.products.splice(index, 1);
            state.shopping_cart.items -= 1;
            state.shopping_cart.price -= parseFloat(product.Cena);
        }
    },
    actions: {
    }
}