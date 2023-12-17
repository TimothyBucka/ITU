// ######################################### FILE: app.js ###############################################
// Authors: Timotej Bucka (xbucka00)
// ######################################################################################################
export function getImageUrl(image) {
    try {
        const url = new URL(image);
        return url;
    } catch (_) { }

    var imageUrl;
    if (image)
        imageUrl = new URL('/public/img/' + image, import.meta.url);
    else
        imageUrl = new URL('/public/img/img_placeholder.jpg', import.meta.url);
    return imageUrl;
}
