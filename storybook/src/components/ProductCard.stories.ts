import type {Meta, StoryObj} from '@storybook/vue3';

import ProductCard from './ProductCard.vue';

const colorOptions = [
    'slate', 'gray', 'zinc', 'neutral', 'stone', 'red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal',
    'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose'
];
const colorShadeOptions = [50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950];

const meta: Meta<typeof ProductCard> = {
    component: ProductCard,
    argTypes: {
        size: { control: 'select', options: ['small', 'medium'] },
        backgroundColor: {
            options: colorOptions,
            control: {
                type: "select"
            }
        },
        borderColor: {
            options: colorOptions,
            control: {
                type: "select"
            }
        },
        titleColor: {
            options: colorOptions,
            control: {
                type: "select"
            }
        },
        priceColor: {
            options: colorOptions,
            control: {
                type: "select"
            }
        },
        backgroundColorShade: {
            options: colorShadeOptions,
            control: {
                type: "select"
            }
        },
        borderColorShade: {
            options: colorShadeOptions,
            control: {
                type: "select"
            }
        },
        titleColorShade: {
            options: colorShadeOptions,
            control: {
                type: "select"
            }
        },
        priceColorShade: {
            options: colorShadeOptions,
            control: {
                type: "select"
            }
        },
        starsDefaultColor: {
            options: colorOptions,
            control: {
                type: "select"
            }
        },
        starsDefaultColorShade: {
            options: colorShadeOptions,
            control: {
                type: "select"
            }
        },
        starsHighlightedColor: {
            options: colorOptions,
            control: {
                type: "select"
            }
        },
        starsHighlightedColorShade: {
            options: colorShadeOptions,
            control: {
                type: "select"
            }
        },
        ratingBgColor: {
            options: colorOptions,
            control: {
                type: "select"
            }
        },
        ratingLabelColor: {
            options: colorOptions,
            control: {
                type: "select"
            }
        },
        ratingBgColorShade: {
            options: colorShadeOptions,
            control: {
                type: "select"
            }
        },
        ratingLabelColorShade: {
            options: colorShadeOptions,
            control: {
                type: "select"
            }
        },
        data: { control: "object" }
    },
    args: {
        size: 'medium',
        backgroundColor: 'gray',
        backgroundColorShade: 800,
        borderColor: 'gray',
        borderColorShade: 700,
        titleColor: 'gray',
        titleColorShade: 100,
        priceColor: 'gray',
        priceColorShade: 100,
        starsDefaultColor: 'gray',
        starsDefaultColorShade: 300,
        starsHighlightedColor: 'blue',
        starsHighlightedColorShade: 300,
        ratingBgColor: 'blue',
        ratingBgColorShade: 600,
        ratingLabelColor: 'gray',
        ratingLabelColorShade: 200,
        data: {
            id: 1,
            title: 'Sample Product',
            description: 'This is a sample product description',
            price: 99.99,
            sku: 'JHHH45656G',
            slug: 'sample-product',
            images: [
                'context.png'
            ],
        }
    },
};

export default meta;
type Story = StoryObj<typeof meta>;

export const MediumProductCard: Story = {
    args: {
        size: 'medium'
    },
};

export const SmallProductCard: Story = {
    args: {
        size: 'small'
    },
}