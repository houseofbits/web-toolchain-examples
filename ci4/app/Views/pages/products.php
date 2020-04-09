<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <h2>Products</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($products as $product) {
            /** @var App\Entities\Product $product */
            ?>
            <tr>
                <td><?=$product->getId()?></td>
                <td><?=$product->getName()?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

</div>


<?= $this->endSection() ?>
