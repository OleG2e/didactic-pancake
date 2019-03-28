<template>
    <article class="media">
        <img :src="avatar">
        <!--<form method="post" action="{{route('image.upload')}}" enctype="multipart/form-data">-->
        @csrf
        <div class="field">
            <label class="label">Аватар:</label>
            <div class="control">
                <input class="file" type="file" name="avatar" @change="GetImage" accept="image/*">
            </div>
        </div>
        <div class="field">
            <div class="control">
                <a href="#" v-if="loaded" class="button is-link" @click.prevent="upload">Сохранить</a>
                <a href="#" v-if="loaded" class="button is-danger" @click.prevent="cancel">Cancel</a>
            </div>
        </div>
        <!--</form>-->
    </article>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                avatar: this.user.avatar,
                loaded: false,
            }
        },
        methods: {
            GetImage(e) {
                let image = e.target.files[0];
                this.read(image);
            },
            upload() {
                axios.post('/upload', {'image': this.avatar})
                    .then(res => this.$toasted.show('Avatar is uploaded', {type: 'success'}))
            },
            read(image) {
                let reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e => {
                    this.avatar = e.target.result
                };
                this.loaded = true
            },
            cancel() {
                this.avatar = this.user.avatar;
                this.loaded = false;
            },
        }
    }
</script>

<style scoped>

</style>