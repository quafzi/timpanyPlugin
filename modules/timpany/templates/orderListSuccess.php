<?php echo count($orders) ?>

<ul class="order_list">
  <?php foreach ($orders as $key=>$order): ?>
  	<li class="order-list-item" id="order-list-item-<?php echo $key ?>">
      <dl>
        <dt><?php echo __('order number') ?></dt>
        <dd><?php echo $order->getId() ?></dd>
        <dt><?php echo __('order date') ?></dt>
        <dd><?php echo $order->getCreatedAt() ?></dd>
        <dt><?php echo __('item count') ?></dt>
        <dd><?php echo $order->getItemCount() ?></dd>
        <dt><?php echo __('article count') ?></dt>
        <dd><?php echo $order->getProductCount() ?></dd>
        <dt><?php echo __('net sum') ?></dt>
        <dd><?php echo $order->getNetSum() ?></dd>
        <dt><?php echo __('gross sum') ?></dt>
        <dd><?php echo $order->getGrossSum() ?></dd>
      </dl>
  	</li>
  <?php endforeach ?>
</ul>
<br clear="all" />
