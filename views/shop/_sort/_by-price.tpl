<label for="sort">
  <?php echo h(__('shop.sort', [], 'shop'));?> 
</label>
<select name="sort" id="sort" onchange="this.form.submit()">
  <option value="">
    <?php echo h(__('shop.default', [], 'shop'));?> 
  </option>
  <option value="price_asc"><?php echo h(__('shop.price', [], 'shop'));?> ↑</option>
  <option value="price_desc"><?php echo h(__('shop.price', [], 'shop'));?> ↓</option>
</select>