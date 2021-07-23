<template>
         <div class="flex border-b border-40">
             <div class="w-1/4 py-4 mt-2"><h4 class="font-normal text-80">{{this.field.name}}</h4></div>
             <div class="w-3/4 py-4 break-words" style="display: flex;">
                <button :disabled="isLoading" class="btn btn-default btn-icon btn-primary mr-3" v-on:click="download()">{{this.field.downloadButtonText}} <div v-show="downloading && isLoading" class="ml-1 loader"></div></button>
                <button :disabled="isLoading" class="btn btn-default btn-icon btn-primary mr-3" v-on:click="view()">{{this.field.viewButtonText}} <div v-show="viewing && isLoading" class="ml-1 loader"></div></button>
             </div>
     </div>
</template>

<script>
import Axios from 'axios';

export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    data() {
        return {
            isLoading:false,
            downloading:false,
            viewing:false,
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
            });
            this.isLoading = false;
            this.downloading = false;
        },
        async view(){
            this.viewing =  true;
            this.isLoading = true;
            var file_url = await this.getFileUrl();
            if(file_url){
                window.open(file_url,'_blank');
            }
            this.isLoading = false;
            this.viewing = false;
        },
        async  getFileUrl() {
        var response = await Axios.get(this.field.url).then((response) => {
                return response.headers["file-url"];
            }).catch((err) => {
                return null;
            });
        return response;
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
