<div class="container mt-3">
    <div class="card-deck">
        <?php
        foreach($products as $product) {
            $this->load->view('partials/product', compact('product'));
        }
        ?>
    </div>
</div> 
