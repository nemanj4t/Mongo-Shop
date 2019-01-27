<template>
    <!-- v-show da stavim u zavisnosti od toga da li ima children ili nema-->
    <nav class="col-md-2 d-none d-md-block sidebar bg-white">
        <div class="sidebar-sticky">

            <ul lass="list-group" v-show="hasChildren">
                <li class="nav-item"><label>Test</label></li>
            </ul>

            <ul class="list-group" v-show="!hasChildren" >
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
    export default {
        name: "categories",
        props: ['category'],
        data() {
            return {
                currentCategory: {},
                hasChildren: false, // v-show na osnovu ovog atributa
                products: [],
                filters: [],
                children: [],
                selectedFilters: []
            }
        },
        methods: {
            showMoreLess(event) {
                if(event.target.innerHTML.includes("Show more")) {
                    event.target.innerHTML = "Show less <i class=\"fas fa-angle-up\"></i>";
                } else if(event.target.innerHTML.includes("Show less")) {
                    event.target.innerHTML = "Show more <i class=\"fas fa-angle-down\"></i>";
                }
            },
            getData() {
                axios.get('/categories/' + this.currentCategory._id)
                    .then(response => {
                        this.currentCategory = response.data.category;
                        this.hasChildren = response.data.hasOwnProperty('subCategories');
                        if(this.hasChildren) {
                            this.children = this.currentCategory.children;
                        } else {
                            this.filters = response.data.filters;
                        }
                        this.initSelectedFilters();
                    });
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
                axios.get('/categories/' + this.currentCategory._id, {
                        params : paramFilters
                    })
                    .then(response => {
                        console.log(response.data.products);
                        // this.products = response.data.products;
                    });
            }
        },
        mounted() {
            this.currentCategory = this.category;
            this.getData();
        }
    }
</script>

<style scoped>

    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100; /* Behind the navbar */
        padding: 48px 0 0; /* Height of navbar */
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    }

    .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
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
