<template>
    <div>
        <br>
        <div class="table">
            <table class="table table-striped mb-5">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Details</th>
                    <th></th>
                    <th><router-link to="/categories/create"><button class="btn btn-primary float-right">Add</button></router-link></th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories">
                        <td>{{category._id}}</td>
                        <td>{{category.name}}</td>
                        <td>{{category.details}}</td>
                        <td>
                            <router-link :to="'/categories/edit/'+ category._id" ><button class="btn btn-sm btn-primary float-right">Edit</button></router-link>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-danger float-right" @click="deleteCategory(category)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            tree: [],
            categories: []
        }
    },
    methods: {
        deleteCategory(category) {
            axios.delete('/categories/' + category._id)
                .then(response =>
                {
                    console.log(response);
                    this.categories.splice(this.categories.indexOf(category), 1);
                    response.data.forEach(category => {
                        this.categories.splice(this.categories.indexOf(category), 1);
                    });
                })
                .catch(error => console.log(error));
        }
    },

    mounted() {
        axios.get('/api/categories')
            .then(response => {this.tree = response.data.tree; this.categories = response.data.categories; console.log(this.tree, this.categories)})
            .catch(error => console.log(error));
    },
}
</script>

<style>

</style>