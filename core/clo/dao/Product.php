<?php

class Clo_Dao_Product extends Clo_Dao implements Clo_IDao {

    protected function getTop10() {
        $q = clo_Clo::$db->prepare('SELECT * FROM t_product WHERE id_product < 3');
        $q->execute();

        $this->collection = array();

        $paramSql = array();
        while($e = $q->fetch(PDO::FETCH_ASSOC)) {
            $products[$e['id_product']] = new Clo_Entity_Product($e);
            $products[$e['id_product']]->params = array();
            $paramSql[] = 'SELECT * FROM t_product_param WHERE id_product = '.$e['id_product'];
        }

        $q = Clo_Clo::$db->prepare(implode(' UNION ', $paramSql));
        $q->execute();

        while($e = $q->fetch(PDO::FETCH_ASSOC)) {
            $productsParams[$e['id_product']][] = new Clo_Entity_ProductParam($e);
        }

        foreach ($products as & $value) {
            $value->params = $productsParams[$value->id_product];
            $this->addCollectionItem($value);
        }

    }
}

?>
