<?php

class Clo_Dao_Url extends Clo_Dao {

	protected function get() {
		$this->addCollectionItem(Clo_Mapper::getMapper('Clo_Mapper_Url')->createEntity(new ArrayObject(array(
			'abs' => $this->globals->domain.$this->params->url,
			'rel' => '/'.$this->params->url
		))));

	}

}

?>
