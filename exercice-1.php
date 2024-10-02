<?php


$data = file_get_contents("./products.json");
$result = json_decode($data, true);

$brandFilter = isset($_GET['brand']) ? $_GET['brand'] : null;

$headers = ["id", "title", "description", "price", "discountPercentage", "rating", "stock", "brand", "category", "thumbnail", "images"];

function displayCell($content) {
    echo "<td>" .$content. "</td>";
}

echo "<form method='GET' action=''>";
echo "Filtrer par marque : <input type='text' name='brand' value='" . $brandFilter . "'>";
echo "<button type='submit'>Appliquer le filtre</button>";
echo "</form><br>";

echo "<table border='1'>";

echo "<tr>";
foreach ($headers as $header) {
    echo "<th>" .$header. "</th>";
}
echo "</tr>";

foreach ($result["products"] as $produit) {

    if ($brandFilter && strtolower($produit["brand"]) !== strtolower($brandFilter)) {
        continue;
    }

    echo "<tr>";
    foreach ($headers as $header) {
        if ($header === "images") {
            displayCell(implode(", ", $produit["images"]));
        } else {
            displayCell($produit[$header]);
        }
    }
    echo "</tr>";
}

echo "</table>";
?>