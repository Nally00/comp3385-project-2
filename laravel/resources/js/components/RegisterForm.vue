<template>
  <form @submit.prevent="handleRegister" class="space-y-4">
    <div>
      <label class="block text-sm font-medium text-slate-700 mb-3">
        Profile Photo <span class="text-slate-400 font-normal">(optional)</span>
      </label>

      <div class="flex items-center gap-4">
        <div
          class="w-20 h-20 rounded-full border-2 border-dashed border-slate-300 flex items-center justify-center text-2xl text-slate-400"
        
          
        </div>

        <div>
          <label
            for="photo"
            class="inline-block px-5 py-2 border border-sky-500 text-sky-500 rounded-lg cursor-pointer hover:bg-sky-50 text-sm font-medium"
          >
            Choose Photo
          </label>

          <input
            id="photo"
            type="file"
            accept=".jpg,.jpeg,.png,.gif"
            class="hidden"
            @change="handlePhotoChange"
          />

          <p class="text-xs text-slate-400 mt-2">JPG, PNG, GIF up to 5MB</p>

          <p v-if="photoName" class="text-xs text-slate-500 mt-1">
            {{ photoName }}
          </p>
        </div>
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-700 mb-2">
        Full Name <span class="text-red-500">*</span>
      </label>
      <input
        v-model="form.name"
        type="text"
        placeholder="e.g. Jane Smith"
        class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-500"
        required
      />
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-700 mb-2">
        Email Address <span class="text-red-500">*</span>
      </label>
      <input
        v-model="form.email"
        type="email"
        placeholder="you@example.com"
        class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-500"
        required
      />
    </div>

    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">
          Password <span class="text-red-500">*</span>
        </label>
        <input
          v-model="form.password"
          type="password"
          placeholder="Min. 6 characters"
          class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-500"
          required
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">
          Confirm Password <span class="text-red-500">*</span>
        </label>
        <input
          v-model="form.password_confirmation"
          type="password"
          placeholder="Repeat password"
          class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-500"
          required
        />
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-700 mb-2">
        Location <span class="text-red-500">*</span>
      </label>
      <input
        v-model="form.location"
        type="text"
        placeholder="e.g. Antigua"
        class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-500"
        required
      />
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-700 mb-2">
        Biography <span class="text-red-500">*</span>
      </label>
      <textarea
        v-model="form.biography"
        rows="4"
        placeholder="Tell clients about your skills, experience, and what you love to do..."
        class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm outline-none focus:border-sky-500 resize-none"
        required
      ></textarea>

      <p class="text-xs text-slate-400 mt-1">
        {{ form.biography.length }} characters
      </p>
    </div>

    <p v-if="errorMessage" class="text-sm text-red-600">
      {{ errorMessage }}
    </p>

    <p v-if="successMessage" class="text-sm text-green-600">
      {{ successMessage }}
    </p>

    <button
      type="submit"
      class="w-full bg-sky-500 text-white py-3 rounded-lg font-medium hover:bg-sky-600"
    >
      Create Account
    </button>

    <p class="text-sm text-center text-slate-500">
      Already have an account?
      <router-link to="/login" class="text-sky-500 font-medium hover:underline">
        Log in
      </router-link>
    </p>
  </form>
</template>


<script setup>
import { reactive, ref } from 'vue'

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  location: '',
  biography: '',
})

const selectedPhoto = ref(null)
const photoName = ref('')
const errorMessage = ref('')
const successMessage = ref('')

const handlePhotoChange = (event) => {
  const file = event.target.files[0]

  if (file) {
    selectedPhoto.value = file
    photoName.value = file.name
  }
}

const handleRegister = async () => {
  errorMessage.value = ''
  successMessage.value = ''

  try {
    const formData = new FormData()
    formData.append('name', form.name)
    formData.append('email', form.email)
    formData.append('password', form.password)
    formData.append('password_confirmation', form.password_confirmation)
    formData.append('location', form.location)
    formData.append('biography', form.biography)

    if (selectedPhoto.value) {
      formData.append('photo', selectedPhoto.value)
    }

    const response = await fetch('/api/v1/auth/register', {
      method: 'POST',
      headers: {
        Accept: 'application/json',
      },
      body: formData,
    })

    const data = await response.json()

    if (!response.ok) {
      errorMessage.value = data.message || 'Registration failed.'
      return
    }

    successMessage.value = 'Account created successfully.'

    form.name = ''
    form.email = ''
    form.password = ''
    form.password_confirmation = ''
    form.location = ''
    form.biography = ''
    selectedPhoto.value = null
    photoName.value = ''

    window.location.href = '/login'
  } catch (error) {
    errorMessage.value = 'Error!'
  }
}
</script>