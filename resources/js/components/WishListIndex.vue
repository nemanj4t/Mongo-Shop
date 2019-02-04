<template>
    <div>
        <div class="row mt-4 justify-content-center">
            <div v-for="product in getWishes.products" class="col-md-2 ml-4 mr-4">
                <product :product="product"></product>
                <button @click="remove(product)" style="width: 100%" class="btn btn-lg btn-danger mb-4">Remove from wishlist</button>
            </div>
        </div>
        <div v-if="getWishes.products.length === 0" class="jumbotron container text-center">
            <h1 class="display-4">Hello, customer!</h1>
            <p class="lead">Your wish list is empty, please add items you're interested in.</p>
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
                'REMOVE_PRODUCT_FROM_WISH_LIST'
            ]),

            remove(product) {
                this.REMOVE_PRODUCT_FROM_WISH_LIST(product);

                axios.post('/wishes/remove', {
                    'product_id' : product._id,
                });
            }
        },

        computed: {
            getWishes() {
                return this.$store.getters.returnWishes;
            }
        },
        mounted() {

        }
    }
</script>
