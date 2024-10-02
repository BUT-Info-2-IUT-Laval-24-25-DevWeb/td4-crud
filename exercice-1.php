<?php
$jsonFile = 'products.json';
$jsonData = file_get_contents($jsonFile);
$products = json_decode($jsonData, true)['products'];
$brandFilter = isset($_GET['brand']) ? $_GET['brand'] : '';
if (!empty($brandFilter)) {
    $products = array_filter($products, function ($product) use ($brandFilter) {
        return $product['brand'] === $brandFilter;
    });
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>
    <style>
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Liste des produits</h2>
    <form method="GET" action="" style="text-align: center; margin-bottom: 20px;">
        <label for="brand">Filtrer par marque :</label>
        <select name="brand" id="brand">
            <option value="">Toutes les marques</option>
            <option value="Apple" <?php if($brandFilter == 'Apple') echo 'selected'; ?>>Apple</option>
            <option value="Samsung" <?php if($brandFilter == 'Samsung') echo 'selected'; ?>>Samsung</option>
        </select>
        <button type="submit">Filtrer</button>
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Remise (%)</th>
            <th>Évaluation</th>
            <th>Stock</th>
            <th>Marque</th>
            <th>Catégorie</th>
            <th>Image</th>
        </tr>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                    <td><?php echo htmlspecialchars($product['title']); ?></td>
                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?> €</td>
                    <td><?php echo htmlspecialchars($product['discountPercentage']); ?> %</td>
                    <td><?php echo htmlspecialchars($product['rating']); ?></td>
                    <td><?php echo htmlspecialchars($product['stock']); ?></td>
                    <td><?php echo htmlspecialchars($product['brand']); ?></td>
                    <td><?php echo htmlspecialchars($product['category']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($product['thumbnail']); ?>" alt="Image du produit" width="50"></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="10" style="text-align: center;">Aucun produit trouvé</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
