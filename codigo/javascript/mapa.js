const mapa = L.map('mapa').setView([-34.9011, -56.1645], 14);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(mapa);

    async function calcularRuta() {
const ImagenDestino = L.icon({
    iconUrl: '../imagenes/marcador.png',

    iconSize: [25, 41],
iconAnchor: [12, 41] });

//coding

const texto = `${direccion.value}, ${departamento.value}, Uruguay`;
document.getElementById('destinoCompleto').value = texto;
const url = 'https://api.geoapify.com/v1/geocode/search?' +
    'text=' + encodeURIComponent(texto) +
    '&filter=countrycode:uy' +
    '&lang=es&limit=1&format=json&apiKey=9019aea7d70c4b5ab165e38dd4ac1998';
const respuesta = await fetch(url);
const dato = await respuesta.json();
const resultado = dato.results[0];
if (resultado) {
    const marcadorH = L.marker(
    [resultado.lat, resultado.lon],
    { draggable: true, icon: ImagenDestino }
    ).addTo(mapa);
    alert(`${resultado.lat}, ${resultado.lon}`);
}

//routing

const origen = [-34.891099, -56.151944];
const destino = [resultado.lat, resultado.lon];
const urlRuta =
    'https://api.geoapify.com/v1/routing?' +
    `waypoints=${origen[0]},${origen[1]}|${destino[0]},${destino[1]}` +
    '&mode=drive' +
    '&units=metric' +
    '&lang=es' +
    '&apiKey=9019aea7d70c4b5ab165e38dd4ac1998';

const resp = await fetch(urlRuta);
const routeo = await resp.json();
const routeoDatos = routeo.features[0].properties;

const dibujo = routeo.features[0].geometry.coordinates[0]
    .map(([lon, lat]) =>[lat, lon]);

L.polyline(dibujo, {color: 'blue', weight: 5}).addTo(mapa);

mapa.fitBounds(L.polyline(dibujo).getBounds());

}
