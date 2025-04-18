export type ProductEntity = {
    id: int;
    title: string;
    sku: string;
    slug: string;
    price: number;
    description: string;
    images: string[];
}

export type ProductCardProps = {
    data: ProductEntity;
    backgroundColor?: string;
    backgroundColorShade?: number;
    size?: string;
}