<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peta Lombok Timur</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <style>
    #map {
      width: 100%;
      height: 100vh;
    }
    .legend {
      background: white;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div id="map"></div>
  <script>
    // Inisialisasi Peta
    const map = L.map('map').setView([-8.6529, 116.5341], 11); // Koordinat Lombok Timur

    // Tambahkan Layer Basemap
    const basemap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // URL GeoServer WMS
    const geoserverUrl = "http://localhost:8080/geoserver/FrendyPgWeb10/wms";

    // Layer Polygon
    const polygonLayer = L.tileLayer.wms(geoserverUrl, {
      layers: "FrendyPgWeb10:lomboktimur_pgweb_ar_12",
      format: "image/png",
      transparent: true,
      attribution: "GeoServer",
    }).addTo(map);

    // Layer Line
    const lineLayer = L.tileLayer.wms(geoserverUrl, {
      layers: "FrendyPgWeb10:lomboktimur_pgweb_ln_12",
      format: "image/png",
      transparent: true,
      attribution: "GeoServer",
    }).addTo(map);

    // Tambahkan Layer Control
    const layerControl = L.control.layers(
      { "OpenStreetMap": basemap }, // Base layers
      { 
        "Batas Administrasi (Polygon)": polygonLayer,
        "Jaringan Jalan (Line)": lineLayer 
      } // Overlay layers
    ).addTo(map);

    // Legend Control
    const legendControl = L.control({ position: "bottomleft" });
        legendControl.onAdd = function () {
    const div = L.DomUtil.create("div", "legend");
    div.style.maxHeight = "50vh"; // Tinggi maksimal setengah layar
    div.style.overflowY = "auto"; // Scrollable secara vertikal
    div.style.background = "white"; // Tambahkan latar belakang agar lebih jelas
    div.style.padding = "10px"; // Tambahkan padding agar terlihat rapi
    div.style.border = "1px solid black"; // Tambahkan border untuk membedakan dengan peta
    div.style.borderRadius = "5px"; // Buat sudutnya melengkung

    // Konten legenda
    div.innerHTML = `
        <strong>Legenda</strong><br>
        <img src="${geoserverUrl}?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&LAYER=FrendyPgWeb10:lomboktimur_pgweb_ar_12" alt="Legend Polygon">
        <br>
        <img src="${geoserverUrl}?REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&LAYER=FrendyPgWeb10:lomboktimur_pgweb_ln_12" alt="Legend Line">
    `;

    // Nonaktifkan scroll pada legenda agar tidak memengaruhi zoom peta
    L.DomEvent.disableScrollPropagation(div);
    L.DomEvent.disableClickPropagation(div);

    return div;
    };

    legendControl.addTo(map);

  </script>
</body>
</html>
