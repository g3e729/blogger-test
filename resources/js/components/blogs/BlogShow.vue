<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a v-bind:href="urls.home" class="btn btn-primary float-right">Back</a>
                    </div>

                    <div class="card-body">
                        <h1>{{ blog.title }}</h1>
                        <div>{{ blog.content}}</div>
                        <p class="pt-3">
                            <small class="float-left">by: <strong>{{ blog.author.name }}</strong></small>
                            <small class="float-right">{{ blog.created_at }}</small>
                        </p>
                        <br>
                        <p>
                            <small class="float-left">likes: <span class="badge"  v-bind:class="{ 'badge-primary': (blog.likes.length > 0) }">{{ blog.likes.length }}</span></small>
                            <form v-bind:action="likeUrl()" method="POST" class="float-right">
                                <input type="hidden" name="_token" v-model="csrf">
                                <button type="submit" class="btn" v-bind:class="{ 'btn-primary': liked }">{{ likeButtonTxt() }}</button>
                            </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            blog: Object,
            urls: Object,
            liked: Number
        },
        data () {
            return {
                csrf: null
            }
        },
        mounted() {
            this.csrf = document.querySelector("meta[name='csrf-token']").getAttribute("content");
            console.log('Blog Component mounted.');
        },
        methods: {
            likeUrl () {
                var url = null;
                url = this.urls.like;
                return url.replace("blogId", this.blog.id);
            },
            likeButtonTxt () {
                if (this.liked == 1) {
                    return 'Liked';
                }

                return 'Like';
            }
        }
    }
</script>
