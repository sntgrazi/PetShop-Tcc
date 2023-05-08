<template>
  <div class="form-inputs">
    <label>{{ label }}</label>
    <input :id="idInput" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :list="lista" />
  </div>
</template>

<script>
export default {
  name: "BaseInput",
  props: ["modelValue", "label", "idInput", "lista"],
  emits: ["update:modelValue"]
};
</script>

<style></style>