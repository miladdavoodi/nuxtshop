<template>
    <div v-on:click="$refs.file.click()" class="uploadFile">
        <input type="file" style="display: none" id="file" ref="file" v-on:change="onChangeFileUpload()"/>
       <a-icon type="cloud-upload" />
       <p v-if="!loading">آپلود تصویر از کامپیوتر</p>
       <p v-if="loading"><a-icon type="loading" /></p>
   </div>
</template>


<script>


export default {

    props: ['category'],

    data(){
      return{
          loading:false,
          uploadProgress:0
      }
    },
    methods:{
        onChangeFileUpload() {

            let _this = this;
            _this.loading = true;

            this.file = this.$refs.file.files[0];
            let formData = new FormData();
            formData.append('file', this.file);

            this.$axios.post('Tools/uploadFile',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'category': _this.category,
                        //'token': this.$store.state.token
                    },
                    onUploadProgress: progressEvent => {
                        var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                        this.uploadProgress = percentCompleted
                        if (this.uploadProgress == 100)
                            this.uploadProgress = 0
                    }
                }
            ).then(function (data) {

                _this.$store.dispatch('setRowFileUpload', data.data.value.img);
                _this.loading = false;

            }).catch(error => {

                _this.loading = false;
                console.error( error.response.data);

            });
        },
    }
}
</script>

<style scoped>
    div.uploadFile{
        background: #e5e6f1;
        padding: 12px 2px 0 2px;
        cursor: pointer;
        text-align: center;
        border-radius: 5px;
        border: 1px solid #d2d4ef;
    }
    div.uploadFile:active{
        background: #d2d4ef;
    }
    div.uploadFile svg{
        font-size: 24px;
        color: #33354c;
        display: inline-block;
        margin: 3px 0;
    }
    div.uploadFile p{
        font-family: IRANSansWeb_Bold, serif;
        display: inline-block;
        margin-right: 20px;
    }
</style>