<template>
  <div class="max-w-6xl mx-auto px-4 py-12">
    <div class="max-w-md mx-auto bg-white border border-slate-200 rounded-2xl shadow-sm p-8">
      <div class="text-center mb-6">
        <p class="text-sky-600 font-semibold mb-2">UniGigs</p>
        <h1 class="text-3xl font-bold mb-2">Welcome back</h1>
        <p class="text-slate-600">Sign in to your account</p>
      </div>

      <LoginForm />
    </div>
  </div>
</template>

<script setup>
import LoginForm from '../components/LoginForm.vue'
</script>