<template>
    <div class="flex flex-col space-y-6">
        <HeadingSmall title="Profile information" description="Update your name and email address" />

        <!-- Responsive two-column layout -->
        <div class="flex flex-col md:flex-row gap-10 items-start">
            <!-- Left: Upload section -->
            <div class="w-full md:w-1/3 flex justify-center md:justify-start">
                <el-upload
                    class="upload-demo w-full"
                    drag
                    action=""
                    :auto-upload="false"
                    :show-file-list="false"
                    @change="handleFileChange"
                >
                    <div class="flex flex-col items-center space-y-2">
                        <!-- Preview shown when image is selected -->
                        <div v-show="previewUrl">
                            <img :src="previewUrl" alt="Preview" class="w-32 h-32 object-cover" />
                            <p class="text-sm text-gray-500">Click or drop to change</p>
                        </div>

                        <!-- Default UI shown when no preview -->
                        <div v-show="!previewUrl">
                            <el-icon class="el-icon--upload"><upload-filled /></el-icon>
                            <div class="el-upload__text">
                                Drop file here or <em>click to upload</em>
                            </div>
                        </div>
                    </div>

                    <template #tip>
                        <div class="el-upload__tip text-xs text-gray-500">
                            jpg/png files under 2MB
                        </div>
                    </template>
                </el-upload>
            </div>

            <!-- Right: Form section -->
            <form @submit.prevent="submit" class="space-y-6 w-full md:w-2/3">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" class="mt-1 block w-full" v-model="name" required autocomplete="name" placeholder="Full name" />
                    <InputError class="mt-2" :message="errors.name?.[0]" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="email"
                        required
                        autocomplete="username"
                        placeholder="Email address"
                    />
                    <InputError class="mt-2" :message="errors.email?.[0]" />
                </div>

                <div class="flex items-center justify-end gap-4">
                    <Button :disabled="loading">
                        <span v-if="loading">Saving...</span>
                        <span v-else>Save</span>
                    </Button>
                </div>
            </form>
        </div>
    </div>
</template>
<script lang="ts">
import { defineComponent} from 'vue'
import HeadingSmall from '@/components/HeadingSmall.vue'
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { UploadFilled } from '@element-plus/icons-vue'

export default defineComponent({
    components: {
        HeadingSmall,
        InputError,
        Button,
        Input,
        Label,
        UploadFilled,
    },
    data : () => ({
        previewUrl: null as string | null,
        name: '',
        email: '',
        image: null as File | null,
        errors: {} as Record<string, string[]>,
        loading: false
    }),

    methods: {
        handleFileChange(uploadFile: any) {
            const file = uploadFile.raw
            if (file) {
                this.image = file

                const reader = new FileReader()
                reader.onload = (e: any) => {
                this.previewUrl = e.target.result
                }
                reader.readAsDataURL(file)
            }
        },
        async submit() {
            const formData = new FormData()
            formData.append('name', this.name)
            formData.append('email', this.email)
            if (this.image) {
                formData.append('image', this.image)
            }

            try {
                await this.$api.patch(`api/settings/profile`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                })
            } catch (err: any) {
                if (err.response && err.response.status === 422) {
                this.errors = err.response.data.errors
                } else {
                console.error('Unexpected error', err)
                }
            }
        },
    },
})
</script>
