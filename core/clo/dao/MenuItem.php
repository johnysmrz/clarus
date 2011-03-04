<?php

class Clo_Dao_MenuItem extends Clo_Dao {

	protected function get() {
		$user = Profiles_Model_Consumer::getInstance();
		$access = empty($user) ? 'logged_out' : 'logged_in';
		if (empty($language))
			$language = $this->globals->activeLanguage;

		$result = dibi::fetchAll('
			SELECT me.*, [title], [link_text], [index_name], [parent], [join_url]
			FROM [section_map] m
			INNER JOIN [section_map_urls] u ON ( [m.id] = [u.id_mapa] AND [u.language] = %s', $language, ')
			INNER JOIN [menubars] me ON [m.id] = [me.id_mapa]
			WHERE [u.classification] != \'hidden\'
			AND [module_group] = %s', $this->params->group, '
			AND [access] != %s', $access, '
			ORDER BY [priority]
			%lmt', isset($limit) ? $limit : NULL
		);

		foreach ($result as $value) {
			$this->addCollectionItem(Clo_Mapper::getMapper('Clo_Mapper_MenuItem')->createEntity($value));
		}
	}

	protected function getById() {
		$language = $this->globals->activeLanguage;

		$result = dibi::fetchAll('
			SELECT m.*
			FROM [section_map] m
			WHERE m.id = '.$this->params->parent.'
			'
		);

		foreach ($result as $value) {
			$this->addCollectionItem(Clo_Mapper::getMapper('Clo_Mapper_MenuItem')->createEntity($value));
		}
	}

}

?>
