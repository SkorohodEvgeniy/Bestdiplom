
storageHref();
function storageHref() {
    if (localStorage.api_token == undefined) {
        window.location = '/';
    }
}
