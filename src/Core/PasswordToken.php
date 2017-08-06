<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Core;

use TheHostingTool\Database\AbstractModel;

class PasswordToken extends AbstractModel
{

	/**
	 * {@inheritdoc}
	 */
	protected $table = 'password_tokens';

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

	/**
	 * Generate a password token for the specified user.
	 *
	 * @param int $userId
	 * @return static
	 */
	public static function generate($userId)
	{
		$token = new static;
		$token->id = str_random(40);
		$token->user_id = $userId;
		$token->created_at = time();
		return $token;
	}

	/**
	 * Define the relationship with the owner of this password token.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('TheHostingTool\Core\User');
	}

	/**
	 * Define the relationship with the owner of this access token.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function staff()
	{
		return $this->belongsTo('TheHostingTool\Core\Staff');
	}

}