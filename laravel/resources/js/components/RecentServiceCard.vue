<template>
  <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
    <div class="relative">
      <img
        :src="imageUrl"
        alt="Service image"
        class="w-full h-44 object-cover"
      />

      <span
        class="absolute top-4 left-4 bg-sky-500 text-white text-xs font-medium px-3 py-1 rounded-full"
      >
        {{ service.category }}
      </span>

      <button
        type="button"
        class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white flex items-center justify-center shadow"
      >
        <span :class="isFavourited ? 'text-red-500' : 'text-slate-400'">
          {{ isFavourited ? '♥' : '♡' }}
        </span>
      </button>
    </div>

    <div class="p-5">
      <h3 class="text-2xl font-semibold text-slate-900 mb-4">
        {{ service.title }}
      </h3>

      <div class="flex items-center justify-between mb-5">
        <p class="text-sky-600 font-bold text-2xl">
          {{ formattedRate }}
        </p>

        <p class="text-sm text-slate-400">
          {{ formattedDate }}
        </p>
      </div>

      <router-link
        :to="`/services/${service.id}`"
        class="block w-full text-center bg-sky-500 text-white py-3 rounded-xl font-medium hover:bg-sky-600"
      >
        View Details
      </router-link>
    </div>
  </div>
</template>





<script setup>
import { computed } from 'vue'

const props = defineProps({
  service: {
    type: Object,
    required: true,
  },
  isFavourited: {
    type: Boolean,
    default: false,
  },
})

const imageUrl = computed(() => {
  if (!props.service.photo) {
    return 'https://via.placeholder.com/600x400?text=Service+Image'
  }

  if (props.service.photo.startsWith('http')) {
    return props.service.photo
  }

  if (props.service.photo.startsWith('demo/')) {
    return `/${props.service.photo}`
  }
  

  return `/storage/${props.service.photo}`
})

const formattedRate = computed(() => {
  const rate = props.service.rate ?? '0'
  const rateType = props.service.rate_type ?? ''
  return `$${rate} ${rateType}`
})

const formattedDate = computed(() => {
  if (!props.service.created_at) {
    return ''
  }

  const date = new Date(props.service.created_at)
  return `Added ${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`
})
</script>