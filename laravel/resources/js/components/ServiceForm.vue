<template>
  <form @submit.prevent="handleSubmit" class="space-y-8">
    <!-- Upload Photo -->
    <div>
      <h2 class="text-lg font-semibold text-slate-800 mb-4">Service Photo</h2>
      <hr class="mb-6" />

      <label class="block text-sm font-medium text-slate-700 mb-3">
        Cover Image <span class="text-red-500">*</span>
      </label>

      <label
        for="service-photo"
        class="border-2 border-dashed border-slate-300 rounded-xl bg-slate-50 h-44 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-100"
      >
        <div class="text-3xl mb-2"</div>
        <p class="text-sm font-medium text-slate-600">
          Click to upload a cover image
        </p>
        <p class="text-xs text-slate-400 mt-1">JPG, PNG up to 10MB</p>
      </label>

      <input
        id="service-photo"
        type="file"
        accept=".jpg,.jpeg,.png"
        class="hidden"
        @change="handlePhotoChange"
      />

      <p v-if="photoName" class="text-sm text-slate-500 mt-3">
        Selected: {{ photoName }}
      </p>
    </div>

    <!-- Service Details -->
    <div>
      <h2 class="text-lg font-semibold text-slate-800 mb-4">Service Details</h2>
      <hr class="mb-6" />

      <div class="space-y-5">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">
            Service Title <span class="text-red-500">*</span>
          </label>

          <input
            v-model="form.title"
            type="text"
            placeholder="e.g. Professional Logo Design & Brand Identity"
            class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-500"
            required
          />

          <p class="text-xs text-slate-400 mt-1">{{ form.title.length }}/100</p>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">
            Description <span class="text-red-500">*</span>
          </label>

          <textarea
            v-model="form.description"
            rows="5"
            placeholder="Describe your service in detail. What will you deliver? What's included? What's your process?"
            class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-500 resize-none"
            required
          ></textarea>

          <p class="text-xs text-slate-400 mt-1">
            {{ form.description.length }} characters
          </p>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">
            Category <span class="text-red-500">*</span>
          </label>

          <select
            v-model="form.category"
            class="w-full md:w-64 border border-slate-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-500"
            required
          >
            <option value="">Select a category...</option>
            <option v-for="category in categories" :key="category" :value="category">
              {{ category }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <!-- Prices -->
    <div>
      <h2 class="text-lg font-semibold text-slate-800 mb-4">Pricing</h2>
      <hr class="mb-6" />

      <div class="grid md:grid-cols-2 gap-5">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">
            Rate (USD) <span class="text-red-500">*</span>
          </label>

          <input
            v-model="form.rate"
            type="number"
            min="0"
            step="0.01"
            placeholder="$ 0.00"
            class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-500"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">
            Rate Type <span class="text-red-500">*</span>
          </label>

          <select
            v-model="form.rate_type"
            class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-500"
            required
          >
            <option v-for="type in rateTypes" :key="type" :value="type">
              {{ type }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <p v-if="errorMessage" class="text-sm text-red-600">
      {{ errorMessage }}
    </p>

    <p v-if="successMessage" class="text-sm text-green-600">
      {{ successMessage }}
    </p>

    <div class="flex justify-end gap-3 pt-2">
      <button
        type="button"
        @click="handleCancel"
        class="px-5 py-3 border border-sky-500 text-sky-500 rounded-lg hover:bg-sky-50"
      >
        Cancel
      </button>

      <button
        type="submit"
        class="px-6 py-3 bg-sky-500 text-white rounded-lg hover:bg-sky-600"
      >
        List My Service
      </button>
    </div>
  </form>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const categories = [
  'Web Development',
  'Graphic Design',
  'Photography',
  'Video Editing',
  'Writing & Editing',
  'Tutoring',
  'Music & Audio',
  'Data Entry',
  'Social Media Management',
  'Translation',
]

const rateTypes = [
  'per hour',
  'per day',
  'per week',
  'per month',
  'fixed',
]

const form = reactive({
  title: '',
  description: '',
  category: '',
  rate: '',
  rate_type: 'per hour',
})

const photoFile = ref(null)
const photoName = ref('')
const errorMessage = ref('')
const successMessage = ref('')

const handlePhotoChange = (event) => {
  const file = event.target.files[0]

  if (file) {
    photoFile.value = file
    photoName.value = file.name
  }
}

const handleCancel = () => {
  router.push('/explore')
}

const handleSubmit = async () => {
  errorMessage.value = ''
  successMessage.value = ''

  const token = localStorage.getItem('token')

  if (!token) {
    errorMessage.value = 'You must be logged in to add a service.'
    return
  }

  if (!photoFile.value) {
    errorMessage.value = 'Please upload a service photo.'
    return
  }

  try {
    const formData = new FormData()
    formData.append('title', form.title)
    formData.append('description', form.description)
    formData.append('category', form.category)
    formData.append('rate', form.rate)
    formData.append('rate_type', form.rate_type)
    formData.append('photo', photoFile.value)

    const response = await fetch('/api/v1/services', {
      method: 'POST',
      headers: {
        Accept: 'application/json',
        Authorization: `Bearer ${token}`,
      },
      body: formData,
    })

    const data = await response.json()

    if (!response.ok) {
      if (data.errors) {
        errorMessage.value = Object.values(data.errors).flat().join(' ')
      } else {
        errorMessage.value = data.message || 'Failed to add service.'
      }
      return
    }

    successMessage.value = 'Service added successfully.'

    form.title = ''
    form.description = ''
    form.category = ''
    form.rate = ''
    form.rate_type = 'per hour'
    photoFile.value = null
    photoName.value = ''
  } catch (error) {
    errorMessage.value = 'Something went wrong.'
  }
}
</script>