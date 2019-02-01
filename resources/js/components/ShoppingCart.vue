<template>
    <div class="dropdown">
        <a href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-shopping-cart"></i>
            <span>Your Cart</span>
            <div v-if="shoppingCart.items > 0" class="qty">{{shoppingCart.items}}</div>
        </a>
        <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuLink">
            <div class="cart-list p-2">
                <div v-for="product in shoppingCart.products" class="product-widget">
                    <div class="product-img">
                        <img src="http://www.independentmediators.co.uk/wp-content/uploads/2016/02/placeholder-image.jpg" alt="">
                    </div>
                    <div class="product-body">
                        <h3 class="product-name"><a href="#">{{product.name}}</a></h3>
                        <h4 class="product-price">${{product.Cena}}</h4>
                    </div>
                    <button @click="removeProductFromCart(product)" class="delete"><i class="fas fa-window-close"></i></button>
                </div>
            </div>
            <div class="cart-summary">
                <small>{{shoppingCart.items}} Item(s) selected</small>
                <h5>SUBTOTAL: ${{shoppingCart.price}}</h5>
            </div>
            <div>
                <button class="btn btn-danger" style="width: 100%" href="#">Checkout  <i class="fa fa-arrow-circle-right"></i></button>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'

    export default {
        methods: {
            ...mapMutations([
                'REMOVE_PRODUCT_FROM_CART'
            ]),

            removeProductFromCart(product) {
                this.REMOVE_PRODUCT_FROM_CART(product);
            }
        },

        computed: {
            shoppingCart() {
                return this.$store.getters.returnShoppingCart;
            }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
