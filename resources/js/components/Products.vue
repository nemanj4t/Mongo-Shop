<template>
    <div class="row mt-4 mb-4">
        <div v-for="product in products" class="col-md-3 mr-4">
            <product :user="user" :category_name=category_name :product="product"/>
        </div>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'

    export default {
        props: ['category_name', 'user'],
        computed: {
            products() {
                return this.$store.getters.returnProducts;
            }
        },
        mounted() {

        }
    }
</script>
