<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <cart-item :cartItem="cartItem" v-for="cartItem in getShoppingCart.products"></cart-item>
            </div>

            <div class="col-md-4">
                Korpa cena itd
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
            ...mapMutations([
                'ADD_PRODUCT_TO_CART',
                'REMOVE_PRODUCT_FROM_CART',
                'DECREMENT_PRODUCT_QUANTITY_IN_CART'
            ])
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

</style>
