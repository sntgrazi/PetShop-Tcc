<template>
  <div class="form-inputs">
    <label>{{ label }}</label>
    <input :id="idInput" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"  :placeholder="place" :type="tipo" :readonly="readonly" /> 
  </div>
</template>

<script>
export default {
  name: "BaseInput",
  props: ["modelValue", "label", "idInput", "lista", "place", "tipo", "readonly"],
  emits: ["update:modelValue"]
};
</script>

<style></style>