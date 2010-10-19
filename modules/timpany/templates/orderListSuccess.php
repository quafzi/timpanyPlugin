<table class="order_list">
  <thead>
    <tr>
      <th><?php echo __('order number') ?></th>
      <th><?php echo __('order date') ?></th>
      <th><?php echo __('item count') ?></th>
      <th><?php echo __('article count') ?></th>
      <th><?php echo __('net sum') ?></th>
      <th><?php echo __('gross sum') ?></th>
    </tr>
  </thead>
  <tbody>
	  <?php foreach ($orders as $key=>$order): ?>
	  	<tr class="order-list-item" id="order-list-item-<?php echo $key ?>">
        <td><?php echo $order->getId() ?></td>
        <td><?php echo $order->getCreatedAt() ?></td>
        <td><?php echo $order->getItemCount() ?></td>
        <td><?php echo $order->getProductCount() ?></td>
        <td><?php echo $order->getNetSum() ?></td>
        <td><?php echo $order->getGrossSum() ?></td>
	  	</tr>
	  <?php endforeach ?>
  </tbody>
</table>
