<template>
            <div class="w-3/4 py-4 break-words" style="display: flex;">
                <button :disabled="isLoading" class="btn btn-default btn-icon btn-primary mr-3" v-on:click="download()">{{this.field.downloadButtonText || "Download"}} <div v-show="downloading && isLoading" class="ml-1 loader"></div></button>
                <button v-show="this.field.viewButtonText" :disabled="isLoading" class="btn btn-default btn-icon btn-primary mr-3" v-on:click="view()">{{this.field.viewButtonText || "View"}} <div v-show="viewing && isLoading" class="ml-1 loader"></div></button>
                <button v-show="this.field.printButtonText" :disabled="isLoading" class="btn btn-default btn-icon btn-primary mr-3" v-on:click="print()">{{this.field.printButtonText || "Print"}} <div v-show="printing && isLoading" class="ml-1 loader"></div></button>
            </div>
</template>

<script>
import Axios from 'axios';
import printJS from 'print-js';
export default {
    props: ['resourceName', 'field'],
    data() {
        return {
            isLoading:false,
            downloading:false,
            viewing:false,
            printing:false,
        }
    },
    methods: {
        async download(){
            this.downloading =  true;
            this.isLoading = true;
            await Axios({
                url: this.field.url,
                method: 'GET',
                responseType: 'blob',
            }).then((response) => {
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');
                fileLink.href = fileURL;
                fileLink.setAttribute('download',response.headers["file-name"]);
                document.body.appendChild(fileLink);
                fileLink.click();
            }).catch((err)=>console.log(err));
            this.isLoading = false;
            this.downloading = false;
        },
        async view(){
            this.viewing =  true;
            this.isLoading = true;
            await Axios.get(this.field.url).then((response) => {
                 window.open(response.headers["file-url"],'_blank');
            }).catch((err)=>console.log(err));
            this.isLoading = false;
            this.viewing = false;
        },
        async print(){
            this.printing =  true;
            this.isLoading = true;
            await Axios.get(this.field.url).then((response) => {
                printJS({printable:response.headers["file-url"], type:response.headers["file-type"]});
            }).catch((err)=>console.log(err));
            this.isLoading = false;
            this.printing = false;
        },

    },
}
</script>
<style scoped>
.loader {
   border: 2px solid #f3f3f3;
   border-top: 2px solid green;
   border-radius: 50%;
   width: 20px;
   height: 20px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
