<template>
    <div class="row mt-4 mb-4 justify-content-center">
        <div class="col-md-12">
            <div id="product-tab" style="margin-top: 0;">
                <ul class="tab-nav">
                    <li><a style="border: solid 1px; padding: 1rem;" class="navitemlink">Check out new products</a></li>
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
                something: 3,
            }
        },

        mounted() {
            axios.get('/api/getNewProducts')
                .then( res => this.products = res.data);
        }
    }
</script>
