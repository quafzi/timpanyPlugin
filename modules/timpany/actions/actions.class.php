<?php
class timpanyActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->products = tpyProductTable::getInstance()->findAll();
  }
  
  public function executeShowProduct(sfWebRequest $request)
  {
    $this->product = tpyProductTable::getInstance()->findOneBySlug($request->getParameter('product'));
    $this->form = new tpyProductToCartForm();
  }
  
  public function executeAddToCart(sfWebRequest $request)
  {
    $product = tpyProductTable::getInstance()->findOneBySlug($request->getParameter('product'));
    $count = $request->getPostParameter('timpany_add_to_cart[count]', 1);
    $this->cart = tpyCart::getInstance($this->getUser());
    $this->cart->addProduct($product, $count);
    $this->cart->save();
    $this->getUser()->setFlash('last_added_product', $product->getSlug());
    $this->redirect('@timpany_cart');
  }
  
  public function executeCart(sfWebRequest $request)
  {
    if ($this->getUser()->hasFlash('last_added_product')) {
      $this->product = tpyProductTable::getInstance()->findOneBySlug($this->getUser()->getFlash('last_added_product'));
    }
    $this->cart = tpyCart::getInstance($this->getUser());
  }
  
  public function executeRemoveCartItem(sfWebRequest $request)
  {
    $this->cart = tpyCart::getInstance($this->getUser());
    $this->cart->removeItem($request->getParameter('product'));
    $this->cart->save();
    $this->redirect('@timpany_cart');
  }
  
  public function executeCheckout(sfWebRequest $request)
  {
    $this->cart = tpyCart::getInstance($this->getUser());
  }
  
  public function executeFinishCheckout(sfWebRequest $request)
  {
    $cart = tpyCart::getInstance($this->getUser());
    if (0 == $cart->getItemCount()) {
    	$this->redirect('@timpany_cart');
    }
    $guardUser = $this->getUser()->isAuthenticated()
      ? $this->getUser()->getGuardUser()
      : null;
    $order_id = $this->getUser()->getAttribute('active_checkout_order', null, 'timpany');
    if (is_null($order_id)) {
      $this->order = tpyOrderTable::getInstance()->createOrder($cart, $guardUser);
	    /* payment requires a persistant order */
	    $this->order->save();
    } else {
    	$this->order = tpyOrderTable::getInstance()->findOneById($order_id);
    }
    $success_url = $this->generateUrl('timpany_payment_approve', array(), true);
    $cancel_url  = $this->generateUrl('timpany_cart', array(), true);
    $payment = $this->order->createPayment($success_url, $cancel_url);
      
    try
    {
      if ($payment->hasOpenTransaction())
      {
        $transaction = $payment->getOpenTransaction();
        if (!$transaction instanceof FinancialApproveTransaction)
          throw new LogicException('This payment has another pending transaction.');
          
        $payment->performTransaction($transaction);
      }
      else
      {
        $payment->approve();
      }
    }
    catch (jmsPaymentException $e)
    {
      // for now there is only one action, so we do not need additional
      // processing here
      if ($e instanceof jmsPaymentUserActionRequiredException
          && $e->getAction() instanceof jmsPaymentUserActionVisitURL)
      {
        $this->amount = $payment->getOpenTransaction()->requested_amount;
        $this->currency = $payment->currency;
        $this->url = $e->getAction()->getUrl();
        
        $this->redirect($this->url);
      }
      
      $this->error = $e->getMessage();
      
      return 'Error';
    }
    
    $this->getUser()->setFlash('notice', 'The payment was approved successfully.');
  }
  
  public function executeCheckoutFinished(sfWebRequest $request)
  {
    $cart = tpyCart::getInstance($this->getUser());
    $cart->clear();
    $cart->save();
    
  	$this->order = Doctrine::getTable('tpyOrder')->findOneById(
      $this->getUser()->getFlash('timpany_last_order_id')
    );
  }
  
  public function executeListOrders(sfWebRequest $request)
  {
    $this->orders = tpyOrderTable::getInstance()->findBySfGuardUserId($this->getUser()->getGuardUser()->getId());
  }
  
  public function executeShowOrder(sfWebRequest $request)
  {
  	if ($request->hasParameter('order_id')) {
  		$this->order = tpyOrderTable::getInstance()
  		  ->findOneById($request->getParameter('order_id'));
  	} else {
      $this->order = tpyOrderTable::getInstance()
        ->findOneByOrderNumber($request->getParameter('order_number'));
  	}
  	if (!$this->order) {
  		$this->getUser()->setFlash('message', $this->getContext()->getI18N()->__('requested order does not exist', null, 'timpany'));
  		$this->redirect('@timpany_orders_list');
  	}
  }
}
