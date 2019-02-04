export default {
    state: {
        products: [],
        wishes: {
            number: 0,
            products: []
        },
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
        },

        returnWishes(state){
            return state.wishes;
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
                state.shopping_cart.price += parseFloat(item.product.Cena);
                state.shopping_cart.items += 1;
            } else {
                state.shopping_cart.products.push(product);
                state.shopping_cart.price += parseFloat(product.quantity * product.product.Cena);
                state.shopping_cart.items += product.quantity;
            }
        },

        REMOVE_PRODUCT_FROM_CART: (state, product) => {
            let item = state.shopping_cart.products.find(el => {
                return el.product._id === product.product._id;
            });
            state.shopping_cart.items -= item.quantity;
            state.shopping_cart.price -= parseFloat(item.quantity * item.product.Cena);
            state.shopping_cart.products.splice(state.shopping_cart.products.indexOf(item), 1);
        },

        DECREMENT_PRODUCT_QUANTITY_IN_CART: (state, product) => {
            for (let ind in state.shopping_cart.products) {
                if (state.shopping_cart.products[ind].product._id === product.product._id) {
                    state.shopping_cart.products[ind].quantity -= 1;
                    state.shopping_cart.items -= 1;
                    state.shopping_cart.price -= parseFloat(product.product.Cena);
                    break;
                }
            }
        },

        INIT_NUMBER_OF_WISHES: (state, number) => {
            state.wishes.number = number;
        },

        INIT_WISHED_PRODUCTS: (state, products) => {
            state.wishes.products = products;
        },

        ADD_PRODUCT_TO_WISH_LIST: (state, product) => {
            state.wishes.products.push(product);
            state.wishes.number += 1;
        },

        REMOVE_PRODUCT_FROM_WISH_LIST: (state, product) => {
            let item = state.wishes.products.find(el => {
                return el._id === product._id;
            });
            state.wishes.number -= 1;
            state.wishes.products.splice(state.wishes.products.indexOf(item), 1);
        }
    },
    actions: {
    }
}
