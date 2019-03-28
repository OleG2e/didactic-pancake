<template>
    <article class="media">
        <img :src="avatar">
        <!--<form method="post" action="{{route('image.upload')}}" enctype="multipart/form-data">-->
        @csrf
        <div class="field">
            <label class="label">Аватар:</label>
            <div class="control">
                <input class="file" type="file" name="image" @change="GetImage" accept="image/*">
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
                avatar: `storage/${this.user.image}`,
                loaded: false,
                file: null,
            }
        },
        methods: {
            GetImage(e) {
                let image = e.target.files[0];
                this.read(image);
                let form = new FormData();
                form.append('image', image);
                this.file = form;
            },
            upload() {
                axios.post('/saveImage', this.file)
                    .then(res => this.$toasted.show('Avatar is uploaded', {type: 'success'}));
                this.loaded = false;
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