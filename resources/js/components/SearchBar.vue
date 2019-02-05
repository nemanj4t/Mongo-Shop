<template>
    <div class="col-md-6">
        <div class="header-search">
            <form v-on:submit.prevent="search()">
                <!--<select class="input-select">-->
                    <!--<option value="0">All Categories</option>-->
                    <!--<option value="1">Category 01</option>-->
                    <!--<option value="1">Category 02</option>-->
                <!--</select>-->
                <input class="input" placeholder="Search here" v-model="keyword">
                <button class="search-btn">Search</button>
            </form>
        </div>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'

    export default {
        data() {
            return {
                keyword: ''
            }
        },

        methods: {
            ...mapMutations([
                'CHANGE_PRODUCTS_FOR_SHOW'
            ]),

            search() {
                axios.get('/search', {
                    params: {
                        'keyword': this.keyword
                    }
                }).then(response => {
                    console.log(response.data);
                    this.CHANGE_PRODUCTS_FOR_SHOW(response.data);
                })
            }
        }
    }
</script>

<style scoped>

</style>
