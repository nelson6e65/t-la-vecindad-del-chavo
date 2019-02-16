<template>
  <form @submit.prevent="upload" @keydown="form.onKeydown($event)">
    <div class="input-group mb-3">
      <div class="custom-file">
        <input id="fu-input" type="file" class="custom-file-input" @change="onFileChange">

        <label class="custom-file-label" for="fu-input">
          ...
        </label>
      </div>

      <div class="input-group-append" />
    </div>

    <div class="row">
      <div class="col-auto">
        <img :src="form.image" class="img-fluid">
      </div>
      <div class="col-sm text-right">
        <v-button class="" :loading="form.busy" type="success">
          Guardar
        </v-button>
      </div>
    </div>

    <div class="form-group" />

    <div class="form-group" />
  </form>
</template>

<script>
import Form from 'vform'

export default {
  props: {
    url: String
  },

  data: () => ({
    form: new Form({
      image: null
    })
  }),

  methods: {
    onFileChange (e) {
      let files = e.target.files || e.dataTransfer.files
      if (!files.length) { return }
      this.createImage(files[0])
    },
    createImage (file) {
      let reader = new FileReader()
      let vm = this
      reader.onload = (e) => {
        vm.form.image = e.target.result
      }
      reader.readAsDataURL(file)
    },
    async upload () {
      const response = await this.form.post(this.url)
        .then(async (data) => {
          this.$swal({
            type: 'success',
            title: '¡Foto actualizada!',
            confirmButtonText: 'Ok'
          })

          this.form.reset()
        }).catch(async (error) => {
          this.$swal({
            type: 'error',
            title: error.response.data.message,
            text: this.form.errors.get('image'),
            // text: '',
            confirmButtonText: 'Ok'
          })
        })
    }
  }
}
</script>

<style scoped>
img {
  max-height: 96px;
}
</style>
