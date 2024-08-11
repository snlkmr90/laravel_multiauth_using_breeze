<script setup>
import { createApp } from 'vue'
import HelloWorld from "./components/HelloWorld.vue";
</script>
<template>
    <header>
        <button @click="count++">{{ count }}</button>
  
      <div class="wrapper">
        <HelloWorld msg="volla" />
      </div>
    </header>
  </template>
  <script>
const app = createApp({
  data() {
    return {
      count: 0
    }
  }
})
</script>