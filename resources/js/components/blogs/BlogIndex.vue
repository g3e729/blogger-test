<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-success" role="alert" v-for="message in messages">
                    <a v-bind:href="message.url">New Blog Post by {{ message.author.name }}</a>
                </div>

                <div class="card" v-if="activeCard == 'list'">
                    <div class="card-header">Blogs <button class="btn btn-primary float-right" v-on:click="showCard('create')">Write</button></div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Created</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="blog in blogs">
                                <td>{{ blog.title }} <span class="badge badge-primary" v-if="blog.likes.length > 0">{{ blog.likes.length }}</span></td>
                                <td>{{ blog.author.name }}</td>
                                <td>{{ blog.created_at }}</td>
                                <td>
                                    <a v-bind:href="blogUrl(blog)" class="btn">view</a>
                                    <button type="button" class="btn" v-on:click="showCard('edit', blog)" v-if="canEdit(blog.user_id)">edit</button>
                                    <button type="button" class="btn text-danger" v-if="canEdit(blog.user_id)" v-on:click="showCard('delete', blog)">delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card" v-if="activeCard == 'create'">
                    <div class="card-header">Create Blog <button class="btn btn-primary float-right" v-on:click="showCard('list')">Cancel</button></div>

                    <div class="card-body">
                        <form v-bind:action="url" method="POST">
                            <input type="hidden" name="_token" v-model="csrf">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </form>
                    </div>
                </div>

                <div class="card" v-if="activeCard == 'edit'">
                    <div class="card-header">Create Blog <button class="btn btn-primary float-right" v-on:click="showCard('list')">Cancel</button></div>

                    <div class="card-body">
                        <form v-bind:action="url" method="POST">
                            <input type="hidden" name="_token" v-model="csrf">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="id" v-model="blog.id">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" v-model="blog.title">
                            </div>
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea class="form-control" id="content" name="content" v-model="blog.content" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </form>
                    </div>
                </div>

                <div class="card" v-if="activeCard == 'delete'">
                    <div class="card-header">Are you sure you want to delete this blog? <button class="btn btn-primary float-right" v-on:click="showCard('list')">Back</button></div>

                    <div class="card-body">
                        <strong>Title:</strong>
                        <p>{{ blog.title }}</p>
                        <strong>Content:</strong>
                        <div class="mb-5">{{ blog.content }}</div>
                        <form v-bind:action="url" method="POST">
                            <input type="hidden" name="_token" v-model="csrf">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" v-model="blog.id">
                            <p class="text-center">
                                <button type="button" class="btn btn-default" v-on:click="showCard('list')">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            blogs: Array,
            loggedid: Number,
            urls: Object
        },
        data () {
            return {
                messages: [],
                activeCard: 'list',
                blog: null,
                url: null,
                csrf: null
            }
        },
        mounted() {
            this.csrf = document.querySelector("meta[name='csrf-token']").getAttribute("content");
            console.log('Blogs Component mounted.');

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('244d88e73f543fc5d789', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('my-channel');
            var message = null;
            var self = this;
            
            channel.bind('my-event', function(data) {
                self.pusher(JSON.stringify(data));
            });
        },
        methods: {
            showCard (card, blog) {
                var url = null;
                this.blog = null;
                this.activeCard = card;

                if (card == 'edit' || card == 'show' || card == 'delete') {
                this.blog = blog;
                }

                if (card == 'create') {
                url = this.urls.store;
                }

                if (card == 'edit') {
                url = this.urls.update;
                url = url.replace("blogId", blog.id);
                }

                if (card == 'delete') {
                url = this.urls.destroy;
                url = url.replace("blogId", blog.id);
                }

                this.url = url;
            },
            canEdit (user_id) {
                return this.loggedid == user_id;
            },
            blogUrl (blog) {
                var url = null;
                url = this.urls.show;
                return url.replace("blogId", blog.id);
            },
            pusher (message) {
                this.messages.push(JSON.parse(message));
            }
        }
    }
</script>
