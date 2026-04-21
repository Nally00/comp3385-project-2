<template>
  <div>
    <section class="bg-gradient-to-r from-slate-950 to-sky-900 text-white">
      <div class="max-w-6xl mx-auto px-4 py-14">
        <h1 class="text-4xl font-bold mb-2">List a New Service</h1>
        <p class="text-slate-300">
          Share your skills with the UniGigs community
        </p>
      </div>
    </section>

    <section class="max-w-4xl mx-auto px-4 py-10">
      <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8">
        <ServiceForm />
      </div>
    </section>
  </div>
</template>

<script setup>
import ServiceForm from '../components/ServiceForm.vue'
</script>