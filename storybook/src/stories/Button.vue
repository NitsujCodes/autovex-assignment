<template>
  <button type="button" class="font-medium rounded-lg text-sm px-5 py-2.5 text-center focus:ring-4 focus:outline-none" :class="classes" @click="onClick" :style="style">{{ label }} </button>
</template>

<script lang="ts" setup>
import './button.css';
import { computed } from 'vue';

const props = withDefaults(defineProps<{
  /**
   * The label of the button
   */
  label: string,
  /**
   * primary or secondary button
   */
  primary?: boolean,
  /**
   * size of the button
   */
  size?: 'small' | 'medium' | 'large',
  /**
   * background color of the button
   */
  backgroundColor?: string,
  bgColor?: string,
  bgColorShade?: number|string,
  labelColor?: string,
  labelColorShade?: number|string,
  hoverColor?: string,
  hoverColorShade?: number|string,

}>(), { primary: false });

const emit = defineEmits<{
  (e: 'click', id: number): void;
}>();

const classes = computed(() => ({
  [`bg-${props.bgColor}-${props.bgColorShade}`]: true,
  [`text-${props.labelColor}-${props.labelColorShade}`]: true,
  [`hover:bg-${props.hoverColor}-${props.hoverColorShade}`]: true
}));

const style = computed(() => ({
  backgroundColor: props.backgroundColor
}));

const onClick = () => {
  emit("click", 1)
};

</script>