<template>
    <div class="row mt-4 mb-4 justify-content-center">
        <div class="col-md-12">
            <div id="product-tab">
                <ul class="tab-nav">
                    <li class="p-0"><a style="border: solid 1px; padding: 1rem;" class="navitemlink">Our customers favorites!</a></li>
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
            axios.get('/api/getGoodPriceProducts')
                .then( res => this.products = res.data);
        }
    }
</script>
