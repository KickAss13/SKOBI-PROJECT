window.onload = function () {

    var latitude = 43.2987298;
    var longitude = 5.379146;

    var map = L.map('map').setView([latitude, longitude], 15);

    L.tileLayer("https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png", {
        minZoom: 1,
        maxZoom: 15,
    }).addTo(map);

    var marker1 = L.marker([latitude, longitude]).addTo(map);
}
