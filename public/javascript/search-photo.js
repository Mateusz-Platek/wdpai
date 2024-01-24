const searchPhoto = document.querySelector('input[name="search"]');
const photosContainer = document.querySelector('div[class="photos"]');

function createPhoto(photo) {
    const template = document.querySelector(".photo-template");
    const clone = template.content.cloneNode(true);
    const image = clone.querySelector("img");
    image.src = `public/uploads/${photo.path}`
    const name = clone.querySelector('div[class="name"]');
    name.innerHTML = photo.name;
    const description = clone.querySelector('div[class="description"]');
    description.innerHTML = photo.description;
    photosContainer.appendChild(clone);
}

function loadPhotos(photos) {
    photos.forEach(photo => {
        createPhoto(photo);
    })
}

searchPhoto.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value};
        fetch("/searchPhotos", {
            method: "POST",
            headers: {
                "Content-type": "application/json"
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (photos) {
            photosContainer.innerHTML = "";
            loadPhotos(photos);
        });
    }
});
