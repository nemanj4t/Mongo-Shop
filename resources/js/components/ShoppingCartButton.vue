<template>
    <div>
        <button @click="addToCart(product)" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
    </div>
</template>

<script>
    import { mapMutations } from 'vuex'

    export default {
        data() {
            return {
                product: {}
            }
        },
        props: ['product_id'],
        computed: {
            getWishes() {
                return this.$store.getters.returnWishes;
            }
        },
        methods: {
            ...mapMutations([
                'ADD_PRODUCT_TO_CART'
            ]),

            addToCart(product) {
                let cartItem = {};
                cartItem.product = product;
                cartItem.quantity = 1;
                axios.post('/shoppingcart/add', {
                    'newProduct': cartItem
                }).then(response => {
                    this.ADD_PRODUCT_TO_CART(cartItem);
                });
            },
        },

        mounted() {
            axios.get('/api/products/' + this.product_id)
                .then(response => this.product = response.data);
        }
    }
</script>
