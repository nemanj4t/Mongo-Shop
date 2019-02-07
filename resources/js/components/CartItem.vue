<template>
        <div class="product">
            <div class="row">
                    <div class="col-md-4">
                        <img style="width:100%;" :src="cartItem.product.image" alt="" />
                    </div>

                    <div class="col-md-6 px-3">
                        <div class="card-block px-3">
                            <h3 class="cart-item-name card-title"><a :href="'/products/' + cartItem.product._id">{{cartItem.product.name}}</a></h3>
                            <h4 class="cart-item-price"><span style="color:black;">Price:</span> {{cartItem.product.price}} $</h4>
                            <h4 class="cart-item-price"><span style="color:black;">Quantity:</span> {{cartItem.quantity}}</h4>
                            <div class="cart-item-btns">
                                <button @click="addProductToCart(cartItem)"><i class="fas fa-plus fa-1x"></i><span class="tooltipp">increase quantity</span></button>
                                <button @click="decrementProductQuantity(cartItem)"><i class="fas fa-minus fa-1x"></i><span class="tooltipp">decrease quantity</span></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="row justify-content-start">
                            <div class="cart-item-btns">
                                <button @click="addToWishList(cartItem.product)" class="add-to-wishlist"><i class="fas fa-heart"></i><span class="tooltipp">add to wishlist</span></button>
                                <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="cart-item-btns">
                                <button @click="removeProductFromCart(cartItem)"><i class="fa fa-trash"></i><span class="tooltipp">remove from cart</span></button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
</template>

<script>

    import { mapState, mapMutations } from 'vuex'

    export default {
        props: ['cartItem'],
        computed: {
        },
        methods: {
            ...mapMutations([
                'ADD_PRODUCT_TO_CART',
                'REMOVE_PRODUCT_FROM_CART',
                'DECREMENT_PRODUCT_QUANTITY_IN_CART',
                'ADD_PRODUCT_TO_WISH_LIST'
            ]),

            addProductToCart(cartItem) {
                axios.post('/shoppingcart/add', {
                    'newProduct': cartItem
                }).then(response => {
                    this.ADD_PRODUCT_TO_CART(cartItem);
                });
            },

            removeProductFromCart(product) {
                axios.get('/shoppingcart/remove/' + product.product._id)
                    .then(response => {
                        this.REMOVE_PRODUCT_FROM_CART(product);
                    });
            },

            decrementProductQuantity(product) {
                if (product.quantity > 1) {
                    axios.get('/shoppingcart/decrement/' + product.product._id)
                        .then(response => {
                            this.DECREMENT_PRODUCT_QUANTITY_IN_CART(product);
                        });
                }
            },

            addToWishList(product) {
                let index = -1;
                this.getWishes.products.forEach(element => {
                    if(element._id === product._id) {
                        index = 0;
                    }
                });

                if(!(index > -1)) {
                    this.ADD_PRODUCT_TO_WISH_LIST(product);
                    axios.post('/wishes', {
                        'product_id' : product._id,
                    });
                }
            }
        },

        mounted() {
            console.log(this.$store.getters.returnWishes);
        }
    }
</script>

<style scoped>
    .cart-item-price {
        color: #D10024;
        font-size: 18px;
    }

    .cart-item-name {
        text-transform: uppercase;
        font-size: 17px;
        font-weight: 700;
        color: #D10024;
    }

    .cart-item-btns>button {
        position: relative;
        width: 40px;
        height: 40px;
        line-height: 40px;
        background: transparent;
        border: none;
        -webkit-transition: 0.2s all;
        transition: 0.2s all;
    }

    .cart-item-btns>button:hover {
        background-color: #E4E7ED;
        color: #D10024;
        border-radius: 50%;
    }

    .cart-item-btns>button .tooltipp {
        position: absolute;
        bottom: 100%;
        left: 50%;
        -webkit-transform: translate(-50%, -15px);
        -ms-transform: translate(-50%, -15px);
        transform: translate(-50%, -15px);
        width: 150px;
        padding: 10px;
        font-size: 12px;
        line-height: 10px;
        background: #1e1f29;
        color: #FFF;
        text-transform: uppercase;
        z-index: 10;
        opacity: 0;
        visibility: hidden;
        -webkit-transition: 0.2s all;
        transition: 0.2s all;
    }

    .cart-item-btns>button:hover .tooltipp {
        opacity: 1;
        visibility: visible;
        -webkit-transform: translate(-50%, -5px);
        -ms-transform: translate(-50%, -5px);
        transform: translate(-50%, -5px);
    }
</style>
