<template>
    <div class="row mb-4 justify-content-center">
        <div class="col-md-12">
            <div id="product-tab">
                <ul class="tab-nav">
                    <li class="p-0"><a style="border: solid 1px; padding: 1rem;" class="navitemlink">WE RECOMMEND</a></li>
                </ul>
            </div>
        </div>
        <!-- /product tab -->
        <div v-for="product in this.products" class="col-3">
            <product :user="user" :category_name=product.category_name :product="product"/>
        </div>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'

    export default {
        props: ['user'],
        data() {
            return {
                products: [],
            }
        },

        mounted() {
            axios.get('/api/getRecommendedProducts')
                .then( res => this.products = res.data);
        }
    }
</script>
