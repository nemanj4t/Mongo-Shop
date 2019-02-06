<template>
    <!-- v-show da stavim u zavisnosti od toga da li ima children ili nema-->
    <nav class="d-none d-md-block sidebar bg-white" style="height: 100%">
        <div class="sidebar-sticky">

            <!--Slider za cenu-->
            <li class="nav flex-column list-group-item">
                <h5 class="nav-link font-weight-bold text-center">Cena:</h5>
                <vue-slider v-on:drag-end="filterByPrice()" v-model="priceFilter"
                                :max="this.getRoundedMaxPrice" :interval="100" :bgStyle="{'background-color': 'red'}"
                            :sliderStyle="{'background-color': 'black'}" :processStyle="{'background-color': 'red'}"
                            :tooltipStyle="{'background-color': 'white', 'color': 'black', 'font-weight': 'bold'}">
                </vue-slider>
            </li>

            <!--Kategorija-->
            <li class="font-weight-bold">{{ this.category.name }}</li>

            <!--Podkategorije-->
            <ul class="nav flex-column" v-if="typeof this.subCategories !== 'undefined'">
                <li v-for="item in this.subCategories">
                    <a :href="'/categories/' + item._id">
                        {{ item.name }}
                    </a>
                </li>
            </ul>

            <!--Filteri-->
            <ul class="list-group" v-if="typeof this.filters !== 'undefined'" >
                <!--Za svaki atribut-->
                <li class="nav flex-column list-group-item" v-for="(filter, fkey) in filters" :key="fkey">
                    <h5 class="nav-link font-weight-bold">{{ fkey }}</h5>
                    <!--Za svaku vrednost-->
                    <ul>
                        <li v-bind:class="[index > 1 ? ['collapse', 'multi-collapse-' + fkey] : '', 'nav-item']" v-for="(item, ikey, index) in filter" :key="ikey">
                            <a class="nav-link" href="#">
                                <input class="form-check-inline" type="checkbox" v-on:change="getFilteredData(fkey, ikey)">{{ ikey }}
                                <span class="font-weight-bold">({{ item }})</span>
                            </a>
                        </li>
                    </ul>
                    <label style="width: 100px;cursor: pointer;" class="nav-link text-nowrap border-top"
                           v-on:click.self="showMoreLess" data-toggle="collapse" :data-target="'.multi-collapse-' + fkey">
                        Show more <i class="fas fa-angle-down"></i>
                    </label>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    import { mapState, mapMutations } from 'vuex';
    import vueSlider from 'vue-slider-component'

    export default {
        components: {
          vueSlider
        },
        name: "categories",
        props: ['category', 'maxPrice', 'subCategories', 'products', 'filters'],
        data() {
            return {
                selectedFilters: [],
                priceFilter: 0, // vueSlider
            }
        },
        methods: {
            ...mapMutations([
                'CHANGE_PRODUCTS_FOR_SHOW'
            ]),

            filterByPrice() {
                axios.get('/search', {
                    params: {
                        'category': this.category._id,
                        'price' : this.priceFilter
                    }
                }).then(response => {
                   this.loadProductsIntoStore(response.data);
                });
            },

            loadProductsIntoStore(products) {
                this.CHANGE_PRODUCTS_FOR_SHOW(products);
            },

            showMoreLess(event) {
                if(event.target.innerHTML.includes("Show more")) {
                    event.target.innerHTML = "Show less <i class=\"fas fa-angle-up\"></i>";
                } else if(event.target.innerHTML.includes("Show less")) {
                    event.target.innerHTML = "Show more <i class=\"fas fa-angle-down\"></i>";
                }
            },

            initSelectedFilters() {
                // Za svaku vrednost svakog filtera cuva da li je checked
                for (let filter in this.filters) {
                    if (this.filters.hasOwnProperty(filter)) {
                        this.selectedFilters[filter] = [];
                        for(let value in this.filters[filter]) {
                            if(this.filters[filter].hasOwnProperty(value)) {
                                this.selectedFilters[filter][value] = false;
                            }
                        }
                    }
                }
            },
            getFilteredData(filter, value) {
                this.selectedFilters[filter][value] = !this.selectedFilters[filter][value];
                let paramFilters = {};
                // Formira parametre samo od selektovanih filtera inverzna funkcija od ove iznad
                for(let f in this.selectedFilters) {
                    let values = [];
                    for(let val in this.selectedFilters[f]) {
                        if(this.selectedFilters[f][val] === true) {
                            values.push(val);
                        }
                    }
                    if(values.length !== 0) {
                        paramFilters[f] = values;
                    }
                }
                axios.get('/api/categories/filter/' + this.category._id, {
                        params : paramFilters
                    })
                    .then(response => {
                        this.loadProductsIntoStore(response.data.products);
                    });
            }
        },

        computed: {
          getRoundedMaxPrice() {
              return Math.ceil(this.maxPrice/100)*100; // round na najblizu narednu 100
          }
        },

        mounted() {
            if(typeof this.filters !== 'undefined') {
                this.initSelectedFilters();
            }
            this.loadProductsIntoStore(this.products);
            this.priceFilter = this.getRoundedMaxPrice;
        }
    }
</script>

<style scoped>

    .sidebar {
        top: 0;
        bottom: 0;
        left: 0;
        padding: 48px 0 0; /* Height of navbar */
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    }

    .sidebar-sticky {
        position: relative;
        top: 0;
        /*height: calc(80vh - 48px);*/
        padding-top: .5rem;
        overflow-x: hidden;
        overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
    }

    @supports ((position: -webkit-sticky) or (position: sticky)) {
        .sidebar-sticky {
            position: -webkit-sticky;
            position: sticky;
        }
    }

    .sidebar .nav-link {
        font-weight: 500;
        color: #333;
    }

    .sidebar .nav-link .feather {
        margin-right: 4px;
        color: #999;
    }

    .sidebar .nav-link.active {
        color: #007bff;
    }

    .sidebar .nav-link:hover .feather,
    .sidebar .nav-link.active .feather {
        color: inherit;
    }

    .sidebar-heading {
        font-size: .75rem;
        text-transform: uppercase;
    }
</style>
