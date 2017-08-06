<?php

namespace TheHostingTool\Core;

use TheHostingTool\Database\AbstractModel;

class Server extends AbstractModel {

	/**
	 * {@inheritdoc}
	 */
	protected $table = 'servers';

	/**
	 * {@inheritdoc}
	 */
	protected $dates = ['created_at'];

	/**
	 * Use a custom primary key for this model.
	 *
	 * @var bool
	 */
	public $incrementing = false;

}