<template>
  <div class="form-inputs">
    <label>{{ label }}</label>
    <input :id="idInput" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :list="lista" :placeholder="place" />
  </div>
</template>

<script>
export default {
  name: "BaseInput",
  props: ["modelValue", "label", "idInput", "lista", "place"],
  emits: ["update:modelValue"]
};
</script>

<style></style>