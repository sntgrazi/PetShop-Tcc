<template>
  <div class="form-inputs">
    <label>{{ label }}</label>
    <input :id="idInput" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
  </div>
</template>

<script>
export default {
  name: "BaseInput",
  props: ["modelValue", "label", "idInput"],
  emits: ["update:modelValue"]
};
</script>

<style></style>