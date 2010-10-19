<table class="order-show">
  <tr>
    <th><?php echo __('order number') ?></th>
    <td><?php echo $order->getOrderNumber() ?></td>
  </tr>
  <tr>
    <th><?php echo __('order date') ?></th>
    <td><?php echo $order->getCreatedAt() ?></td>
  </tr>
</table>
<table class="order-items-list">
  <thead>
    <tr>
      <th><?php echo __('article', null, 'timpany') ?></th>
      <th><?php echo __('gross price', null, 'timpany') ?></th>
      <th><?php echo __('count', null, 'timpany') ?></th>
      <th><?php echo __('gross sum', null, 'timpany') ?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th colspan="3">
        <?php echo __('total gross sum', null, 'timpany') ?>
      </th>
      <td><?php echo format_currency(round($order->getGrossSum(), 2), 'EUR') ?></td>
    </tr>
  </tfoot>
  <tbody>
    <?php foreach ($order->getItems() as $item): ?>
      <tr>
        <td><?php echo $item->getName() ?></td>
        <td><?php echo format_currency(round($item->getGrossPrice(), 2), 'EUR') ?></td>
        <td><?php echo $item->getCount() ?></td>
        <td><?php echo format_currency(round($item->getGrossSum(), 2), 'EUR') ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>