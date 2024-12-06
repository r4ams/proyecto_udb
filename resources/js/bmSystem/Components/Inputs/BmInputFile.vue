<script>
import { defineComponent } from 'vue'
import BmButton from "@/bmSystem/Components/Buttons/BmButton.vue";
import BmButtonIcon from "@/bmSystem/Components/Buttons/BmButtonIcon.vue";
import BlueIconDescargar from "@/Icons/Generales/blueIconDescargar.vue";
import BlueIconTrash from "@/Icons/Generales/blueIconTrash.vue";

export default defineComponent({
    components: {BlueIconTrash, BlueIconDescargar, BmButtonIcon, BmButton },
    props: {
        id: { type: String, default: 'drag-and-drop-input' },
        multiple: { type: Boolean, default: false },
        title: { type: String, default: '' },
        text: { type: String, default: '' },
        loading: { type: Boolean, default: false },
        height: {
            type: String,
            default: "64"
        },
        typeFile:{
            type: String,
            required: true,
        },
        mini:{
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {
            files: [],
            acceptedFiles: [],
            extensionesPorTipoDocumento : {
                excel: ['xls', 'xlsx', 'csv'],
                pdf: ['pdf','doc', 'docx', 'txt']
            }
        }
    },
    computed: {
        uploadInfo() {
            return this.files.length === 1
                ? this.files[0].name
                : `${this.files.length} archivo seleccionados`
        },
        filesUploads(){
            return this.files.map((file) => {
                let size;
                let invalid = false;
                let name = file.name;
                if(file.size  >= 1048576){
                    size = (file.size / 1048576).toFixed(2) + " MB";
                }else{
                    size = (file.size / 1024).toFixed(2) + " KB";
                }
                const extension = file.name.split('.').pop().toLowerCase();
                if (!this.extensionesPorTipoDocumento[this.typeFile].includes(extension)) {
                    invalid = true;
                }
                if (this.mini && name.length > 22) {
                    const extension = name.slice(name.lastIndexOf('.'));
                    name = name.slice(0, 18) + '...' + extension;
                }
                return {
                    name:name,
                    size: size,
                    invalid: invalid,
                };
            });
        },
        acceptFileType() {
            const extensiones = {
                excel: ".xlsx, .xls, application/vnd.ms-excel, .csv",
                pdf: ".pdf, .doc, .docx, .txt",
            };
            return extensiones[this.typeFile] || "";
        }
    },
    methods: {
        async handleUpload(e) {
            this.files = Array.from(e.target.files) || []
            this.acceptedFiles = Array.from(e.target.files) || []
            for (let i = 0; i < this.acceptedFiles.length; i++) {
                const file = this.acceptedFiles[i];
                const extension = file.name.split('.').pop().toLowerCase();
                if (!this.extensionesPorTipoDocumento[this.typeFile].includes(extension)) {
                    this.acceptedFiles.splice(i, 1);
                }
            }
            this.$emit("update:modelValue", this.acceptedFiles);
        },
        removeFile(index) {
            const tempFile = this.files[index];
            this.acceptedFiles = this.acceptedFiles.filter((item) => item.name !== tempFile.name);
            if (index >= 0 && index < this.files.length) {
                this.files.splice(index, 1);
            }
            this.$emit("update:modelValue", this.acceptedFiles);
        },
    }
});
</script>



<template>
    <div class="flex items-center justify-center w-full">
        <label
            :for="id"
            class="flex flex-col items-center justify-center w-full border-2 border-dashed rounded-lg"
            :class="[loading ? 'loading' : 'default', `h-${height}` ]"
        >
            <div v-if="loading" class="flex flex-col items-center justify-center pt-5 pb-6">
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                    Cargando documentos..
                </p>
            </div>
            <div v-else class="flex flex-col items-center justify-center pt-5 pb-6" >
                <slot>
                    <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        <span v-if="title">
                            <span class="font-semibold">{{ title }}</span>
                        </span>
                        <span  v-else>
                            <span class="font-semibold">Clic para cargar</span> o arrastra y suelta
                        </span>
                    </p>
                    <p  v-if="text" class="text-xs text-gray-500 dark:text-gray-400">{{ text }}</p>
                </slot>
            </div>
            <input
                :id="id"
                type="file"
                class="hidden"
                :multiple="multiple"
                @change="handleUpload"
                :accept="acceptFileType"
            />
        </label>
    </div>
    <div v-if="files.length" class="mt-4">
        <h6 class="font-medium text-bmGrey-500">Archivo(s) seleccionado(s):</h6>
    </div>
    <div v-if="files.length"
         class="
         w-full
         max-h-40 overflow-y-auto
         border rounded-2xl border-bmGrey-100
         px-3 mt-4 py-3
         ">
        <div v-for="(file, index) in filesUploads" :key="index"
              :class="file.invalid?'invalid_file_container' : 'file_container'">
            <div>
                <small class="text-sm pl-4 text-bmPurple"> {{ `${file.name.toLowerCase()} - ${file.size}`}}</small>
                <div class="pl-4">
                    <small  v-if="file.invalid" class="font-bold text-danger-600 text-xs">archivo invalido, no se cargará.</small>
                </div>
            </div>
            <div class="pr-4 flex items-center" @click="removeFile(index)">
                <blue-icon-trash class="fill-bmGrey-300 hover:fill-danger-400 p-0.5"/>
            </div>
        </div>
    </div>
    <!-- <slot name="file" :files="files" :uploadInfo="uploadInfo"></slot>-->
</template>

<style scoped>
.loading {
    @apply cursor-not-allowed border-bmCyan-400 bg-bmCyan-100;
}
.default {
    @apply cursor-pointer border-gray-300 bg-gray-50 hover:bg-gray-100;
}

.file_container{
    @apply border rounded-2xl border-bmGrey-100 my-4 w-full flex justify-between py-2;
}
.invalid_file_container{
    @apply border rounded-2xl border-danger-200 my-4 w-full flex justify-between py-2;
}
</style>


