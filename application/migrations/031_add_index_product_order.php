<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_add_index_product_order extends CI_Migration {
    public function up(){
        $sql = "CREATE INDEX order_no ON `order`(order_no)";
        $this->db->query($sql);

        $sql = "CREATE INDEX order_product_order_no ON order_product(order_no)";
        $this->db->query($sql);

        $sql = "CREATE INDEX order_product_product_id ON order_product(product_id)";
        $this->db->query($sql);

        $sql = "CREATE INDEX product ON product(id)";
        $this->db->query($sql);
    }
    public function down(){

    }
}   