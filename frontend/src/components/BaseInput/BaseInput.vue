<template>
  <div class="form-inputs">
    <label>{{ label }}</label>
    <input :id="idInput" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"  :type="tipo" :readonly="readonly" :name="name"/> 
  </div>
</template>

<script>
export default {
  name: "BaseInput",
  props: ["modelValue", "label", "idInput", "name", "tipo", "readonly"],
  emits: ["update:modelValue"]
};
</script>

<style></style>