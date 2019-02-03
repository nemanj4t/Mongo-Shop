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
            let item = state.shopping_cart.products.find(el => {
                return el.product._id === product.product._id;
            });
            if(item) {
                item.quantity++;
                state.shopping_cart.price += parseFloat(item.product.price);
                state.shopping_cart.items += 1;
            } else {
                state.shopping_cart.products.push(product);
                state.shopping_cart.price += parseFloat(product.quantity * product.product.price);
                state.shopping_cart.items += product.quantity;
            }
        },

        REMOVE_PRODUCT_FROM_CART: (state, product) => {
            let item = state.shopping_cart.products.find(el => {
                return el.product._id === product.product._id;
            });
            state.shopping_cart.items -= item.quantity;
            state.shopping_cart.price -= parseFloat(item.quantity * item.product.price);
            state.shopping_cart.products.splice(state.shopping_cart.products.indexOf(item), 1);
        },

        DECREMENT_PRODUCT_QUANTITY_IN_CART: (state, product) => {
            for (let ind in state.shopping_cart.products) {
                if (state.shopping_cart.products[ind].product._id === product.product._id) {
                    state.shopping_cart.products[ind].quantity -= 1;
                    state.shopping_cart.items -= 1;
                    state.shopping_cart.price -= parseFloat(product.product.price);
                    break;
                }
            }
        }
    },
    actions: {
    }
}
