<template>
    <div class="container">
        <div class="row justify-content-center mb-3" ref="imageUpload">
           <div class="col-12 bg-dark rounded mt-5 py-3 text-center text-white">Drop Image Here</div>
        </div>
    </div>
</template>

<script>
import Dropzone from 'dropzone'
    export default {

    data:function () {
      return {
          dropzone: null,
      }
    },
        mounted() {
            this.dropzone = new Dropzone(this.$refs.imageUpload, {
                url: '/api/images'
            })
        }
    }
</script>
