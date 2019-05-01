<template>
    <div class="container">
        <progress class="progress is-primary" :value="fileProgress" max="100"></progress>
        <hr>
        <input type="file" name="image" accept="image/*" multiple @change="fileInputChange">
        <hr>

        <div class="row">
            <div class="col-sm-6">
                <h3 class="text-center">Файлы в очереди ({{filesOrder.length}})</h3>
                <ul class="list-group">
                    <li class="list-group-item" v-for="file in filesOrder">
                        {{file.name}} : {{file.type}}
                    </li>
                </ul>
            </div>
            <div class="col-sm-6">
                <h3 class="text-center">Downloaded files ({{filesFinish.length}})</h3>
                <ul class="list-group">
                    <li class="list-group-item" v-for="file in filesFinish">
                        {{file.name}} : {{file.type}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                filesOrder: [],
                filesFinish: [],
                fileProgress: 0,
                fileCurrent: '',
            }
        },
        methods: {
            async fileInputChange() {
                let files = Array.from(event.target.files);
                this.filesOrder = files.slice();
                for (let item of files) {
                    await this.uploadFile(item);
                }
            },
            async uploadFile(item) {
                let form = new FormData();
                form.append('image', item);
                await axios.post('/posts/create/image/upload', form, {
                    onUploadProgress: (itemUpload) => {
                        this.fileProgress = Math.round((itemUpload.loaded / itemUpload.total) * 100);
                        this.fileCurrent = item.name + '' + this.fileProgress;
                    }
                })
                    .then(response => {
                        this.fileProgress = 0;
                        this.fileCurrent = '';
                        this.filesFinish.push(item);
                        this.filesOrder.splice(item, 1);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
        }
    }
</script>
