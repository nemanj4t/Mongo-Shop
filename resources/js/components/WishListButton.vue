<template>
    <div class="float-right">
        <button @click="addToWishList(product)" class="add-to-cart-btn ml-4"><i class="fas fa-heart"></i> add to wish list</button>
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
                'ADD_PRODUCT_TO_WISH_LIST'
            ]),

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
            axios.get('/api/products/' + this.product_id)
                .then(response => this.product = response.data);
        }
    }
</script>
