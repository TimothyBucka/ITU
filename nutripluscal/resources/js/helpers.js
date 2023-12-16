export function getImageUrl(image) {
    const imageUrl = new URL('/public/img/' + image, import.meta.url);
    return imageUrl;
}
