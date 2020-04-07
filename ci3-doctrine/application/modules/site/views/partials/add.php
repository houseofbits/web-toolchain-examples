<div class="container mt-3">
  <h2>Add new product</h2>

  <form action="/site/add" method="post" class="was-validated">

    <?php
        if (validation_errors()) {
    ?>
    <div class="alert alert-danger"><?=validation_errors();?></div>
    <?php
        }
    ?>        

    <div class="form-group">
      <label for="name">Name:</label>
      <input type="name" class="form-control" id="name" placeholder="Enter name" name="name" required>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>

    <div class="form-group">
      <label for="image_url">Image URL:</label>
      <input type="name" class="form-control" id="name" placeholder="Enter URL" name="image_url" required>
      <div class="invalid-feedback">Please fill out this field.</div>
    </div>

    <button type="submit" class="btn btn-dark">Add</button> <a href="/site" class="btn btn-primary">Cancel</a>

   </form>
</div>