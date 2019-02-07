<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <cart-item class="p-4" :cartItem="cartItem" :key="cartItem._id" v-for="cartItem in getShoppingCart.products"></cart-item>
            </div>

            <div v-if="getShoppingCart.products.length !== 0" class="col-md-4" style="margin-top: 20px">
                <div class="container">
                    <div class="card">
                        <div class="cart-summary p-4">
                            <p>{{getShoppingCart.items}} Item(s) selected</p>
                            <h5>SUBTOTAL: ${{getShoppingCart.price}}</h5>
                        </div>
                        <div>
                            <button class="btn btn-danger" style="width: 100%" href="#">Checkout  <i class="fa fa-arrow-circle-right"></i></button>
                        </div>
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
