

//CUSTOM GOOGLE MAP
function initMap() {
  map = new google.maps.Map(document.getElementById('map-box'), {
    center: {lat: 53.34619001916453, lng: -6.251790086266539},
    zoom: 14,
    mapId: '52dcb2d4339dcfed',
    mapTypeControl: false,
    fullscreenControl: false,
    streetViewControl: false

  });

 const marker = new google.maps.Marker({
    position: {lat: 53.34619001916453, lng: -6.251790086266539},
    map,
    title: "Mossco Restaurant",
    icon: {
      url: "assets/images/home/icons/mossco-map-pin-v2.svg",
      scaledSize: new google.maps.Size(100, 110)
    },
    animation: google.maps.Animation.DROP
  });

  const infowindow = new google.maps.InfoWindow({
    content: "MOSSco Restaurant",
  });

  marker.addListener("click", () => {
    infowindow.open(map, marker);
  });
}
// LOCATION
//53.34619001916453, -6.251790086266539
