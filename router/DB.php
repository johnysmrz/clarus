<?php

namespace clarus\router;

/**
 * @todo
 */
class DB extends Router {

    public function match() {

        if(isset ($_SERVER['REDIRECT_URL'])) {
            $url = $_SERVER['REDIRECT_URL'];
        } else {
            $url = '/';
        }

        $q = DB::query('SELECT * FROM v_url WHERE u_url = ?', $url);
        if($r = $q->fetch()) {
            $this->setPresenter($r['c_presenter']);
            $this->setAction($r['c_action']);
            $this->setParam($r['c_param']);
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>
