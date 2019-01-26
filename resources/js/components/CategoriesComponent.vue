<template>
    <!-- v-show da stavim u zavisnosti od toga da li ima children ili nema-->
    <nav class="col-md-2 d-none d-md-block sidebar bg-white">
        <div class="sidebar-sticky">

            <ul lass="list-group" v-show="hasChildren">
                <li class="nav-item"><label>Test</label></li>
            </ul>

            <ul class="list-group" v-show="!hasChildren">
                <!--Za svaki atribut-->
                <li class="nav flex-column list-group-item">
                    <h5 class="nav-link font-weight-bold" >Kapacitet:</h5>
                    <!--Za svaku vrednost-->
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <input class="form-check-inline" type="checkbox" value="">4GB
                            </a>
                        </li>
                        <li class="nav-item collapse multi-collapse">
                            <a class="nav-link" href="#">
                                <input class="form-check-inline" type="checkbox" value="">8GB
                            </a>
                        </li>
                        <li class="nav-item collapse multi-collapse">
                            <a class="nav-link" href="#">
                                <input class="form-check-inline" type="checkbox" value="">16GB
                            </a>
                        </li>
                    </ul>
                    <label style="width: 100px;cursor: pointer;" class="nav-link text-nowrap border-top"
                           v-on:click.self="showMoreLess" data-toggle="collapse" data-target=".multi-collapse">
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
                products: {},
                filters: {},
                children: {}
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
                        this.hasChildren = this.currentCategory.hasOwnProperty('children');
                        if(this.hasChildren) {
                            this.children = this.currentCategory.children;
                        } else {
                            this.filters= this.currentCategory.filters;
                        }
                        console.log(this);
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
