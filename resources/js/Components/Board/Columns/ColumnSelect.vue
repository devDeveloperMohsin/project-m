
<script setup>

const emit = defineEmits(['columnClicked'])

</script>

<template>
  <div class="column-content column-select">
    <span class="badge" style="background-color: green;" @click="() => emit('columnClicked')">Completed</span>
  </div>
</template>

<style scoped>
/* Column Select */
.column-select .badge {
  text-transform: none;
  width: 100%;
  opacity: 0.9;
  cursor: pointer;
  font-weight: 400;
}

.column-select .badge:hover {
  opacity: 1;
}

/* End Column Select */
</style>