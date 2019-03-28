<template>
    <div>
        <div v-if="!cropped">
            <vue-avatar
                    :width=400
                    :height=400
                    ref="vueavatar"
                    @vue-avatar-editor:image-ready="onImageReady"
                    image="https://ru.vuejs.org/images/logo.png"
            >
            </vue-avatar>
            <br>
            <vue-avatar-scale
                    ref="vueavatarscale"
                    @vue-avatar-editor-scale:change-scale="onChangeScale"
                    :width=250
                    :min=1
                    :max=3
                    :step=0.02
            >
            </vue-avatar-scale>
            <br>
            <button v-on:click="saveClicked">Click</button>
        </div>
        <div v-else>
            <img :src="croppedImage">
            <button @click="startCropping">Назад</button>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import VueAvatar from '../vue-avatar-editor/src/components/VueAvatar.vue'
    import VueAvatarScale from '../vue-avatar-editor/src/components/VueAvatarScale.vue'

    export default {
        components: {
            VueAvatar,
            VueAvatarScale
        },
        data() {
            return {
                croppedImage: null,
                cropped: false,
            }
        },
        methods: {
            onChangeScale(scale) {
                this.$refs.vueavatar.changeScale(scale)
            },
            saveClicked() {
                var img = this.$refs.vueavatar.getImageScaled();
                this.croppedImage = img.toDataURL();
                this.cropped = true;
            },
            onImageReady(scale) {
                this.$refs.vueavatarscale.setScale(scale)
            },
            startCropping() {
                this.cropped = false;
            },
        }
    }
</script>

<style scoped>

</style>