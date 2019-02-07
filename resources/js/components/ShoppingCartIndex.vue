<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="product-tab" style="margin-top: 0px;">
                <ul class="tab-nav">
                    <li><a style="border: solid 1px; padding: 1rem;" class="navitemlink">Shopping Cart</a></li>
                </ul>
            </div>
        </div>
        
            <div class="col-md-7" offset-md-1>
                <cart-item style="margin-top: 0px" :cartItem="cartItem" :key="cartItem._id" v-for="cartItem in getShoppingCart.products"></cart-item>
            </div>
            <div v-if="getShoppingCart.products.length !== 0" class="col-md-3">
                <div class="container">
                    <div class="card">
                        <div class="cart-summary text-center">
                            <p class="font-weight-bold">{{getShoppingCart.items}} Item(s) selected</p>
                            <h5 class="font-weight-bolder">SUBTOTAL: ${{getShoppingCart.price}}</h5>
                        </div>
                        <div>
                            <a class="btn btn-danger" style="width: 100%" href="/checkout">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        <div v-if="getShoppingCart.products.length === 0" class="jumbotron container text-center">
            <h1 class="display-4">Hello, customer!</h1>
            <p class="lead">Your shopping cart is empty, please add items you're interested in.</p>
            <hr class="my-4">
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="/home" role="button">Home</a>
            </p>
        </div>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'

    export default {
        methods: {

        },

        computed: {
            getShoppingCart() {
                return this.$store.getters.returnShoppingCart;
            }
        },

        mounted() {

        }
    }
</script>

<style scoped>
    .cart {
        margin-top: 15px;
    }
</style>
