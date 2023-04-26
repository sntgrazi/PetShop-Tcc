<template>
  <div class="form-inputs">
    <label>{{ label }}</label>
    <input :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
  </div>
</template>

<script>
export default {
  name: "BaseInput",
  props: ["modelValue", "label"],
  emits: ["update:modelValue"]
};
</script>

<style></style>