<template>
    <div>
        <br>
        <div class="table">
            <table class="table table-striped mb-5">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>User since</th>
                    <th>Delete user</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users">
                        <td>{{user.id}}</td>
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.created_at}}</td>
                        <td>
                            <div class = "row">
                                <button class="btn btn-sm btn-danger float-right" @click="deleteUser(user)">Delete</button>
                            </div>
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
            users: []
        }
    },
    methods: {
        deleteUser(user) {
            axios.delete('/users/' + user._id)
                .then(response => 
                {
                    console.log(response);
                    this.users.splice(this.users.indexOf(user), 1);
                })
                .catch(error => console.log(error));
        }
    },

    mounted() {
        axios.get('/api/users')
            .then(response => {this.users = response.data; console.log(this.users)})
            .catch(error => console.log(error));
    },
}
</script>

<style>

</style>