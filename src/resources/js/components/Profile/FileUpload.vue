<template>
  <div>
    <v-text-field
      :value="path"
      :label="label"
      :disabled="disabled || form.busy"
      append-icon="mdi-paperclip"
      :append-outer-icon="preview && clearable ? 'mdi-delete' : ''"
      outlined
      readonly
      :error="!!error"
      :error-messages="error"
      @click:append="$refs.input.click()"
      @click:append-outer="clear"
    >
      <template v-slot:prepend-inner>
        <v-avatar height="28" width="auto" max-width="56" tile @click="!disabled && $refs.input.click()">
          <img v-if="isImage && preview" :src="preview" :alt="label" :disabled="disabled || form.busy">
          <v-icon v-else :disabled="disabled || form.busy">
            mdi-image-outline
          </v-icon>
        </v-avatar>
      </template>
      <template v-slot:append-outer>
        <slot name="append-outer" />
      </template>
    </v-text-field>

    <input ref="input" type="file" class="d-none" :accept="accept" @change="uploadFile">
  </div>
</template>

<script>
import Form from 'vform'
import objectToFormData from '~/plugins/objectToFormData'

export default {
  props: {
    label: {
      type: String,
      required: true
    },
    value: {
      validator: value => typeof value === 'string' || value === null || typeof value === 'undefined',
      required: true
    },
    accept: {
      type: String,
      required: false,
      default: 'image/*'
    },
    name: {
      type: String,
      required: true
    },
    folder: {
      type: String,
      required: true
    },
    clearable: {
      type: Boolean,
      required: false,
      default: false
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  data () {
    return {
      error: null,
      imageBase64: null,
      form: new Form({
        file: null,
        name: this.name,
        folder: this.folder
      }),
      uploadedFilePath: null
    }
  },

  computed: {
    path () {
      return this.form.busy
        ? this.$t('Uploading...')
        : ((!this.uploadedFilePath && !this.value) || this.uploadedFilePath === ''
          ? this.$t('Upload a file')
          : (this.uploadedFilePath || this.displayValue))
    },
    preview () {
      return this.imageBase64 || this.displayValue
    },
    displayValue () {
      return this.value && !this.value.match(/\//) ? `/storage/${this.folder}/${this.value}` : this.value
    },
    isImage () {
      // const extension = (this.uploadedFilePath || this.displayValue).split('/').pop().toLowerCase()
      const file = this.uploadedFilePath || this.displayValue
      const extension = file && file.substring(file.lastIndexOf('.') + 1)
      return ['png', 'gif', 'jpg', 'jpeg', 'svg', 'tiff'].indexOf(extension) > -1
    }
  },

  watch: {
    uploadedFilePath (uploadedFilePath) {
      this.$emit('input', uploadedFilePath)
    }
  },

  async created() {

    this.id = this.$route.params.id
    console.log('pr>', this.$route.params)
    console.log('id:', this.id)
    console.log('name:', this.name)

  },

  methods: {
    clear () {
      this.uploadedFilePath = ''
      this.imageBase64 = null
    },
    async uploadFile (event) {
      let posturl = ''
    
      this.error = null

      this.form.file = event.target.files[0]

      // console.log('dataid:', this.dataid);
      // console.log('data-id:', this.data-id);

      if (this.form.file) {
        let imageBase64
        const reader = new FileReader()
        // define a callback function to run, when FileReader finishes its job
        reader.onload = e => { imageBase64 = e.target.result }
        // Start the reader job - read file as a data url (base64 format)
        reader.readAsDataURL(this.form.file)

        const options = { transformRequest: [(data, headers) => objectToFormData(data)] }

        if(this.id){
          if(this.name == 'content_image')
            posturl = `/api/content/uploadimages/` + this.id
          else
            posturl = `/api/content/uploadcover/` + this.id
        }else{
          posturl = `/api/content/blog/upload`
        }
       
        await this.form.submit(`post`, posturl, options)
        .then((res) => {

          console.log('res:', res.data);

          this.uploadedFilePath = res.data.data
          // console.log('uploadedFilePath:', this.uploadedFilePath);

          localStorage.setItem(this.name, res.data.data)

          this.imageBase64 = imageBase64

        }).catch(error => {
          
          this.error = error.message
        });

        /*if (data.success) {
          this.uploadedFilePath = data.data
          console.log('uploadedFilePath:', this.uploadedFilePath);

          this.imageBase64 = imageBase64
        } else {
          this.error = data.message
        }*/
      }
    }
  }
}
</script>
<style scoped>
.v-avatar {
  cursor: pointer;
}
</style>
