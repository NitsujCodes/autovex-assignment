<script setup lang="ts">
import type {ProductEntity} from "../Types/Product";
import Button from "../stories/Button.vue";

export type ProductCardProps = {
  data: ProductEntity;
  backgroundColor?: string;
  backgroundColorShade?: number;
  borderColor?: string;
  borderColorShade?: number;
  titleColor?: string;
  titleColorShade?: number;
  priceColor?: string;
  priceColorShade?: number;
  starsDefaultColor?: string;
  starsDefaultColorShade?: number;
  starsHighlightedColor?: string;
  starsHighlightedColorShade?: number;
  ratingBgColor?: string;
  ratingBgColorShade?: number;
  ratingLabelColor?: string;
  ratingLabelColorShade?: number;
  size?: string;
  addToCartButton?: object;
};

const props = withDefaults(defineProps<ProductCardProps>(),
    {
      size: 'medium',
      backgroundColor: 'gray',
      backgroundColorShade: 800,
      borderColor: 'gray',
      borderColorShade: 700,
      titleColor: 'gray',
      titleColorShade: 900,
      priceColor: 'gray',
      priceColorShade: 900,
      starsDefaultColor: 'gray',
      starsDefaultColorShade: 300,
      starsHighlightedColor: 'blue',
      starsHighlightedColorShade: 300,
      ratingBgColor: 'blue',
      ratingBgColorShade: 300,
      ratingLabelColor: 'gray',
      ratingLabelColorShade: 200
    }
);
</script>

<template>
  <div :class="`w-full max-w-sm border rounded-lg shadow-sm bg-${props.backgroundColor}-${props.backgroundColorShade}`">
    <a href="#">
      <img class="p-8 rounded-t-lg" :src="props.data.images[0]" alt="product image" />
    </a>
    <div class="px-5 pb-5">
      <a href="#">
        <h5 class="" :class="`text-xl font-semibold tracking-tight text-${props.titleColor}-${props.titleColorShade}`">{{props.data.title}}</h5>
      </a>
      <div class="flex items-center mt-2.5 mb-5">
        <div class="flex items-center space-x-1 rtl:space-x-reverse">
          <svg class="w-4 h-4" :class="`text-${props.starsHighlightedColor}-${props.starsHighlightedColorShade}`" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
          </svg>
          <svg class="w-4 h-4" :class="`text-${props.starsHighlightedColor}-${props.starsHighlightedColorShade}`" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
          </svg>
          <svg class="w-4 h-4 " :class="`text-${props.starsHighlightedColor}-${props.starsHighlightedColorShade}`" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
          </svg>
          <svg class="w-4 h-4 " :class="`text-${props.starsHighlightedColor}-${props.starsHighlightedColorShade}`" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
          </svg>
          <svg class="w-4 h-4" :class="`text-${props.starsDefaultColor}-${props.starsDefaultColorShade}`" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
          </svg>
        </div>
        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-sm ms-3" :class="`bg-${ratingBgColor}-${ratingBgColorShade} text-${ratingLabelColor}-${ratingLabelColorShade}`">5.0</span>
      </div>
      <div class="flex items-center justify-between">
        <span class="text-3xl font-bold" :class="`text-${props.priceColor}-${props.priceColorShade}`">&euro;{{('' + props.data.price).replace('.', ',')}}</span>
        <Button
            bg-color="green" bg-color-shade="700"
            label-color="gray" label-color-shade="200"
            hover-color="green" hover-color-shade="800"
            label="Add To Cart"
        ></Button>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>