<?php # ShoppingCart.php  

class ShoppingCart
{ 

    protected $items; 
     
    function __construct()
    { 
        $this->items = array();
    } 

    public function getItems()
    {
        return $this->items;
    }

    // Returns a Boolean indicating if the cart is empty: 
    public function isEmpty()
    {
        return empty($this->items);
    }

    public function addItem(Item $item)
    {
        $pid = $item->getPID();
        // Throw an exception if there's no pid
        if (!$pid) throw new Exception('The cart requires items with unique ID values.');
        // Add or update
        if (isset($this->items[$pid]))
        {
            $this->updateItemByPId($pid, $this->items[$pid]['qty'] + 1); // update
        }
        else
        {
            $this->items[$pid] = array('item' => $item, 'qty' => 1); // add new item
        }

        return $this;
    } 

    // Changes an item already in the cart by pid 
    public function updateItemByPId($pid, $qty)
    {
        if ($qty === 0 || $qty == '0')
            $this->deleteItem($pid);
        else // display whatever the user entered so the user can fix the problem
        {
            $this->items[$pid]['qty'] = $qty;  
        } 

        return $this;  
    }

    public function deleteItem($itemPID)
    {         
        if (isset($this->items[$itemPID]))
        { 
            unset($this->items[$itemPID]); 
        } 
         
        return $this; 
    } 

    public function count()
    { 
        return count($this->items); 
    } 

    public function countItemsQty()
    { 
        $count = 0; 
        foreach ($this->items as $arr)
        {  
            if (valid_qty($arr['qty']))
                $count += $arr["qty"]; 
        } 
        return $count; 
    }     

    public function PrintShoppingCart() 
    {
        if ($this->count() > 0)
        { 
            echo '<table id="cart" cellspacing="0" align="center">'; 
            echo '<tr><th>Items</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>&nbsp;</th></tr>'; 
            $total = 0.00; 

            foreach ($this->items as $arr)
            { 
                $item = $arr['item']; // Get the item object 
                echo '<tr><td width="200px">' . $item->getName() . '</td>'; 
                echo '<td>$' . $item->getPrice() . '</td>'; 
                echo '<td width="150px"><form>'; 
                echo '<input type="text" size="1" name="qty" maxlength="3" value="' . $arr['qty'] . '"</input>'; 
                echo '<input type="hidden" name="pid" value="' . $item->getPID() . '">'; 
                echo '<input type="submit" class="btn-link" name="update" value="update">'; 
                echo '<input type="submit" class="btn-link" name="remove" value="remove">';                 
                echo '</form></td>'; 

                $subtotal =  $item->getPrice() * $arr['qty']; 
                echo '<td>$' . number_format($subtotal, 2). '</td>';                 
                echo '</tr>'; 
                $total += $subtotal; 
            }
            echo '<tr><td colspan="2" class="last-row">&nbsp;</td><td class="last-row"><b>Total:</b></td><td class="last-row">$' . number_format($total, 2) .'</td>'; 
            echo '<td class="last-row">&nbsp;</td></tr></table>';
        }
        else
            echo '<div style="text-align:center">[ Empty ]<br></div>';
    }
}

function valid_qty($qty)
{
    $checkQty = '/^[0-9]+$/';

    if (preg_match($checkQty, $qty))
        return true;
    else
        return false;
}

?>
