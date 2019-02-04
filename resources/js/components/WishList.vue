<template>
    <div>
        <a href="/wishlist">
            <i class="fas fa-heart"></i>
            <span>Your Wishlist</span>
            <div v-if="getWishes.number > 0" class="qty">{{getWishes.number}}</div>
        </a>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'

    export default {
        methods: {
            ...mapMutations([
                'INIT_NUMBER_OF_WISHES',
                'INIT_WISHED_PRODUCTS'
            ]),

            initWishes(wishes) {
                this.INIT_NUMBER_OF_WISHES(wishes.length);
                this.INIT_WISHED_PRODUCTS(wishes);
            }
        },
        props: ['wishes'],
        computed: {
            getWishes() {
                return this.$store.getters.returnWishes;
            }
        },
        mounted() {
            console.log('Component mounted.');
            axios.get('/wishes')
                .then(response => {
                    this.initWishes(response.data);
                    console.log(response.data);
                });
        }
    }
</script>
